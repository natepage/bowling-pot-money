<?php

declare(strict_types=1);

use App\Infrastructure\Security\Auth0\Auth0Authenticator;
use App\Infrastructure\Security\Auth0\Auth0Entrypoint;
use App\Infrastructure\Security\Auth0\Auth0UserProvider;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $config, string $env): void {
    $config->passwordHasher(PasswordAuthenticatedUserInterface::class)
        ->algorithm('auto');

    $config->provider('auth0')
        ->id(Auth0UserProvider::class);

    $config->firewall('dev')
        ->pattern('^/(_(profiler|wdt)|css|images|js)/')
        ->security(false);

    $config->firewall('api')
        ->pattern('^/api')
        ->security(false);

    $config->firewall('main')
        ->pattern('^/')
        ->customAuthenticators([Auth0Authenticator::class])
        ->entryPoint(Auth0Entrypoint::class)
        ->provider('auth0')
        ->logout()
            ->path('admin_logout');

    $config->accessControl()
        ->path('^/admin')
        ->roles('ROLE_ADMIN');

    $config->accessControl()
        ->path('^/')
        ->roles('ROLE_USER');

    if ($env === 'test') {
        $config->passwordHasher(PasswordAuthenticatedUserInterface::class)
            ->algorithm('auto')
            ->cost(4)
            ->timeCost(3)
            ->memoryCost(10);
    }
};
