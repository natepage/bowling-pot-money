<?php
declare(strict_types=1);

namespace App\Infrastructure\Security\Auth0;

use App\Infrastructure\Auth0\Auth0Sdk;
use Bugsnag\Client;
use EonX\EasyErrorHandler\Interfaces\ErrorHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Throwable;

final class Auth0Authenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly Auth0Sdk $auth0Sdk,
        private readonly ErrorHandlerInterface $errorHandler,
    ) {
    }

    public function authenticate(Request $request): Passport
    {
        try {
            $auth0User = new Auth0User($this->auth0Sdk->getUser($request));
        } catch (Throwable $throwable) {
            $newThrowable = new AuthenticationException($throwable->getMessage(), (int)$throwable->getCode(), $throwable);

            $this->errorHandler->report($newThrowable);

            throw $newThrowable;
        }

        return new SelfValidatingPassport(
            new UserBadge($auth0User->getUserIdentifier(), static function () use ($auth0User) {
                return $auth0User;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }

    public function supports(Request $request): ?bool
    {
        return $request->isMethod('GET') && $request->getPathInfo() === '/admin/auth0/callback';
    }
}