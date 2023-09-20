<?php
declare(strict_types=1);

namespace App\Infrastructure\Auth0;

use App\Infrastructure\Helper\UrlHelper;
use Auth0\SDK\Auth0;
use Laminas\Uri\Uri;
use Symfony\Component\HttpFoundation\Request;

final class Auth0Sdk
{
    public function __construct(private readonly Auth0 $auth0)
    {
    }

    /**
     * @throws \Auth0\SDK\Exception\NetworkException
     * @throws \Auth0\SDK\Exception\StateException
     */
    public function getUser(Request $request): array
    {
        $this->auth0->exchange(
            $request->query->get('redirect_uri'),
            $request->query->get('code'),
            $request->query->get('state')
        );

        \dd($this->auth0->getAccessToken());

        return $this->auth0->getUser();
    }

    /**
     * @throws \Auth0\SDK\Exception\ConfigurationException
     */
    public function loginUrl(?string $redirectAfterLogin = null): string
    {
        $redirectUrl = null;
        $redirectUri = $this->auth0->configuration()->getRedirectUri();

        if ($redirectAfterLogin !== null && $redirectUri !== null) {
            $uri = new Uri($redirectUri);

            $query = $uri->getQueryAsArray();
            $query['redirectAfterLogin'] = UrlHelper::urlSafeBase64Encode($redirectAfterLogin);

            $redirectUrl = $uri->setQuery($query)->toString();
        }

        return $this->auth0->login($redirectUrl);
    }

    /**
     * @throws \Auth0\SDK\Exception\ConfigurationException
     */
    public function logoutUrl(string $redirectTo): string
    {
        return $this->auth0->logout($redirectTo);
    }
}