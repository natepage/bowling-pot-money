<?php

declare(strict_types=1);

namespace App\Infrastructure\Bref\Runtime;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

abstract class AbstractSymfonyHttpKernel extends Kernel
{
    public function boot(): void
    {
        $this->prepareCacheDir(parent::getCacheDir(), $this->getCacheDir());
        $this->ensureLogDir($this->getLogDir());

        parent::boot();
    }

    public function getCacheDir(): string
    {
        if ($this->isLambda()) {
            return '/tmp/cache/' . $this->environment;
        }

        return parent::getCacheDir();
    }

    public function getLogDir(): string
    {
        if ($this->isLambda()) {
            return '/tmp/var/log';
        }

        return parent::getLogDir();
    }

    private function ensureLogDir(string $writeLogDir): void
    {
        if ($this->isLambda() === false || \is_dir($writeLogDir)) {
            return;
        }

        (new Filesystem())->mkdir($writeLogDir);
    }

    private function isLambda(): bool
    {
        return \getenv('LAMBDA_TASK_ROOT') !== false;
    }

    private function logToStderr(string $message): void
    {
        \file_put_contents('php://stderr', \date('[c] ') . $message . PHP_EOL, FILE_APPEND);
    }

    private function prepareCacheDir(string $readOnlyDir, string $writeDir): void
    {
        if ($this->isLambda() === false || \is_dir($writeDir) || \is_dir($readOnlyDir) === false) {
            return;
        }

        $startTime = \microtime(true);
        $cacheDirectoriesToCopy = ['pools'];
        $filesystem = new Filesystem;
        $filesystem->mkdir($writeDir);

        $scanDir = \scandir($readOnlyDir, SCANDIR_SORT_NONE);
        if ($scanDir === false) {
            return;
        }

        foreach ($scanDir as $item) {
            if (\in_array($item, ['.', '..'], true)) {
                continue;
            }

            // Copy directories to a writable space on Lambda.
            if (\in_array($item, $cacheDirectoriesToCopy, true)) {
                $filesystem->mirror("$readOnlyDir/$item", "$writeDir/$item");
                continue;
            }

            // Symlink all other directories
            // This is especially important with the Container* directories since it uses require_once statements
            if (\is_dir("$readOnlyDir/$item")) {
                $filesystem->symlink("$readOnlyDir/$item", "$writeDir/$item");
                continue;
            }

            // Copy all other files.
            $filesystem->copy("$readOnlyDir/$item", "$writeDir/$item");
        }

        $this->logToStderr(\sprintf(
            'Symfony cache directory prepared in %s ms.',
            \number_format((\microtime(true) - $startTime) * 1000, 2)
        ));
    }
}
