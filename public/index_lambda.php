<?php

use App\Infrastructure\Bref\Runtime\SymfonyHttpHandler;
use App\Infrastructure\HttpKernel\Kernel;
use EonX\EasyBugsnag\Interfaces\ValueOptionInterface as EasyBugsnagValueOptionInterface;
use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

// Because of serverless it looks to PHP that it's running in CLI
$_SERVER[EasyBugsnagValueOptionInterface::RESOLVE_REQUEST_IN_CLI] = true;

(new Dotenv())
    ->setProdEnvs(['prod'])
    ->usePutenv(false)
    ->bootEnv(__DIR__ . '/../.env');

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

return new SymfonyHttpHandler($kernel);
