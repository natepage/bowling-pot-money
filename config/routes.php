<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $imports = [
        'App\Admin\Controller' => '../src/Admin/Controller/',
        'App\Debug\Controller' => '../src/Debug/Controller/',
        'App\Team\Controller' => '../src/Team/Controller/',
    ];

    foreach ($imports as $namespace => $path) {
        $routingConfigurator->import([
            'path' => $path,
            'namespace' => $namespace,
        ], 'attribute');
    }
};
