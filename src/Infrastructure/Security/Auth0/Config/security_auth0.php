<?php
declare(strict_types=1);

use App\Infrastructure\Security\Auth0\Auth0LogoutListener;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->set(Auth0LogoutListener::class)
        ->tag('kernel.event_listener');
};