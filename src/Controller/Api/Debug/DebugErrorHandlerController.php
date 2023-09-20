<?php
declare(strict_types=1);

namespace App\Controller\Api\Debug;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/debug-error-handler', name: 'debug_error_handler', methods: ['GET'])]
final class DebugErrorHandlerController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        throw new \RuntimeException('debug');
    }
}