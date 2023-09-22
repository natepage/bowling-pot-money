<?php

namespace App\Infrastructure\Bref\Runtime;

use Bref\Context\Context;
use Bref\Event\Http\HttpHandler;
use Bref\Event\Http\HttpRequestEvent;
use Bref\Event\Http\HttpResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

class SymfonyHttpHandler extends HttpHandler
{
    private const TRUSTED_HEADER_SET = Request::HEADER_X_FORWARDED_FOR
        | Request::HEADER_X_FORWARDED_HOST
        | Request::HEADER_X_FORWARDED_PORT
        | Request::HEADER_X_FORWARDED_PROTO;

    public function __construct(private readonly HttpKernelInterface $kernel)
    {
        // Add REMOTE_ADDR as app runs behind CloudFront
        Request::setTrustedProxies(['127.0.0.1', 'REMOTE_ADDR'], self::TRUSTED_HEADER_SET);
    }

    /**
     * @throws \Exception
     */
    public function handleRequest(HttpRequestEvent $event, Context $context): HttpResponse
    {
        $request = SymfonyRequestBridge::convertRequest($event, $context);
        $response = $this->kernel->handle($request);

        if ($this->kernel instanceof TerminableInterface) {
            $this->kernel->terminate($request, $response);
        }

        return SymfonyRequestBridge::convertResponse($response);
    }
}
