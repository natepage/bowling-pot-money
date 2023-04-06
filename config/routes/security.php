<?php

declare(strict_types=1);

use App\Infrastructure\Security\Auth0\Auth0CallbackController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator
        ->add('admin_auth0_callback', '/admin/auth0/callback')
        ->controller(Auth0CallbackController::class)
        ->methods(['GET']);

    $routingConfigurator
        ->add('admin_logout', '/admin/logout')
        ->methods(['GET']);
};
