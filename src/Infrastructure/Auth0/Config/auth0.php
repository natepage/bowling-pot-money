<?php
declare(strict_types=1);

use App\Infrastructure\Auth0\BaseAuth0Factory;
use Auth0\SDK\Auth0;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->set(BaseAuth0Factory::class)
        ->arg('$clientId', env('AUTH0_CLIENT_ID'))
        ->arg('$clientSecret', env('AUTH0_CLIENT_SECRET'))
        ->arg('$redirectUri', env('AUTH0_REDIRECT_URI'));

    $services
        ->set(Auth0::class)
        ->factory([service(BaseAuth0Factory::class), 'create']);
};