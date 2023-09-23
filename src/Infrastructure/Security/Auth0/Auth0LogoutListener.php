<?php
declare(strict_types=1);

namespace App\Infrastructure\Security\Auth0;

use App\Infrastructure\Auth0\Auth0Sdk;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final class Auth0LogoutListener
{
    public function __construct(
        private readonly Auth0Sdk $auth0Sdk,
        private readonly RouterInterface $router,
    ) {
    }

    /**
     * @throws \Auth0\SDK\Exception\ConfigurationException
     */
    public function __invoke(LogoutEvent $event): void
    {
        $request = $event->getRequest();
        $referer = $request->headers->get('referer');

        $redirectToRoute = \is_string($referer) && \str_contains($referer, 'admin') ? 'admin_index' : 'web_homepage';
        $redirectTo = $this->router->generate($redirectToRoute, [],  UrlGeneratorInterface::ABSOLUTE_URL);

        $logoutUrl = $this->auth0Sdk->logoutUrl($redirectTo);

        $event->setResponse(new RedirectResponse($logoutUrl));
    }
}
