<?php
declare(strict_types=1);

namespace App\Controller\Api\Debug;

use Bugsnag\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/debug-bugsnag', name: 'debug_bugsnag', methods: ['GET'])]
final class DebugBugsnagController extends AbstractController
{
    public function __construct(private readonly Client $client)
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->client->notifyException(new \RuntimeException('debug'));

        return new JsonResponse(['message' => 'debug bugsnag response']);
    }
}