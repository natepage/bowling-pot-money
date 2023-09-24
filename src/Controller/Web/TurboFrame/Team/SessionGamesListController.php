<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}/games',
    name: '_frame_session_games_list',
    methods: [Request::METHOD_GET]
)]
final class SessionGamesListController extends AbstractTurboFrameController
{
    public function __construct(
        private readonly GameRepository $gameRepository,
    ) {
    }

    public function __invoke(string $teamId, string $sessionId): Response
    {
        $games = $this->gameRepository->findBySessionId($sessionId);

        return $this->renderFrame('web/team/_includes/session_games_list.html.twig', [
            'games' => $games,
        ]);
    }
}
