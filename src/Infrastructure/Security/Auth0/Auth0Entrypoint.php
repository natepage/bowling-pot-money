<?php
declare(strict_types=1);

namespace App\Infrastructure\Security\Auth0;

use App\Infrastructure\Auth0\Auth0Sdk;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

final class Auth0Entrypoint implements AuthenticationEntryPointInterface
{
    public function __construct(private readonly Auth0Sdk $auth0Sdk)
    {
    }

    /**
     * @throws \Auth0\SDK\Exception\ConfigurationException
     */
    public function start(Request $request, ?AuthenticationException $authException = null): RedirectResponse
    {
        return new RedirectResponse($this->auth0Sdk->loginUrl($request->getUri()));
    }
}