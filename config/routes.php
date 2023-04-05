<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import([
        'path' => '../src/Admin/Controller/',
        'namespace' => 'App\Admin\Controller',
    ], 'attribute');

    $routingConfigurator->import([
        'path' => '../src/Infrastructure/Security/Auth0/',
        'namespace' => 'App\Infrastructure\Security\Auth0',
    ], 'attribute');

    $routingConfigurator
        ->add('admin_logout', '/admin/logout')
        ->methods(['GET']);
};
