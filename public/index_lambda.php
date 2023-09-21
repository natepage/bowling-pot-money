<?php

use App\Infrastructure\HttpKernel\Kernel;
use Runtime\Bref\SymfonyHttpHandler;
use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

(new Dotenv())
    ->setProdEnvs(['prod'])
    ->usePutenv(false)
    ->bootEnv(__DIR__ . '/../.env');

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

return new SymfonyHttpHandler($kernel);
