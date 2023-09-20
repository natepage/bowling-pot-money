<?php
declare(strict_types=1);

namespace App\Controller\Api\Debug;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/debug-logging', name: 'debug_logging', methods: ['GET'])]
final class DebugLoggingController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->logger->debug('logging message in controller');

        return new JsonResponse(['message' => 'debug logging response']);
    }
}