<?php
declare(strict_types=1);

namespace App\Controller\Api\Session\Game;

use App\Game\GameCreator;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sessions/{sessionId}/games', name: 'session_game_create', methods: ['POST'])]
final class CreateGamesController extends AbstractController
{
    public function __construct(
        private readonly GameCreator $gameCreator,
        private readonly SessionRepository $sessionRepository
    ) {
    }

    public function __invoke(string $sessionId): RedirectResponse
    {
        // TODO: Deal with not found session
        $session = $this->sessionRepository->find($sessionId);

        $this->gameCreator->createGamesForSession($session);

        // TODO: redirect to better page for facing users
        return $this->redirectToRoute('admin_index');
    }
}