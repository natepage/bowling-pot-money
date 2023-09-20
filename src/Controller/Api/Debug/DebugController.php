<?php
declare(strict_types=1);

namespace App\Controller\Api\Debug;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/debug-app', name: 'debug_app', methods: ['GET'])]
final class DebugController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['message' => 'debug response']);
    }
}