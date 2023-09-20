<?php
declare(strict_types=1);

namespace App\Infrastructure\Auth0;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

final class BaseAuth0Factory
{
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $redirectUri
    ){
    }

    /**
     * @throws \Auth0\SDK\Exception\ConfigurationException
     */
    public function create(): Auth0
    {
//        $config = new SdkConfiguration(
//            domain: 'bowling-coke-money.au.auth0.com',
//            clientId: $this->clientId,
//            redirectUri: $this->redirectUri,
//            clientSecret: $this->clientSecret,
//            audience: ['https://bowling-coke-money.com'],
//            cookieSecret: 'secret',
//        );

        $config = new SdkConfiguration(
            domain: 'auth.eonx.com',
            clientId: 'rQgiYcZYPru4b0xF4qirZaExxgGHGkka',
            redirectUri: $this->redirectUri,
            clientSecret: 'T4XibJQBYIxarFE9jf5Lbo4e5nWaML0ctclWTewvaziRaCwmWI_eZBrjmWFAuhkT',
            audience: ['com.eonx.payment-gateway.v3'],
            cookieSecret: 'secret',
        );

        return new Auth0($config);
    }
}