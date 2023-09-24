<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    // Admin
    $routingConfigurator->import([
        'path' => __DIR__ . '/../src/Controller/Admin',
        'namespace' => 'App\Controller\Admin',
    ], 'attribute');

    // Api
    $routingConfigurator->import([
        'path' => __DIR__ . '/../src/Controller/Api',
        'namespace' => 'App\Controller\Api',
    ], 'attribute')->prefix('api');

    // Web Frontend
    $routingConfigurator->import([
        'path' => __DIR__ . '/../src/Controller/Web/Frontend',
        'namespace' => 'App\Controller\Web\Frontend',
    ], 'attribute');

    // Web Turbo frames
    $routingConfigurator->import([
        'path' => __DIR__ . '/../src/Controller/Web/TurboFrame',
        'namespace' => 'App\Controller\Web\TurboFrame',
    ], 'attribute')->prefix('_frame');
};
