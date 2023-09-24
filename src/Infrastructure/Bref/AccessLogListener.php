<?php

declare(strict_types=1);

namespace App\Infrastructure\Bref;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

final class AccessLogListener
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(TerminateEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        $this->logger->debug(\sprintf(
            '[access_log] %s - "%s %s%s %s" %d "%s"',
            $request->getClientIp(),
            $request->getMethod(),
            $request->getPathInfo(),
            $request->getQueryString() ? '?' . $request->getQueryString() : null,
            $request->getProtocolVersion(),
            $response->getStatusCode(),
            $request->headers->get('user-agent', '<no_user_agent>')
        ));
    }
}