<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Entity\Enum\GameStatusEnum;
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

    public function __invoke(Request $request, string $teamId, string $sessionId): Response
    {
        $status = $request->query->get('status');
        if (\is_string($status) && $status !== '') {
            $status = GameStatusEnum::tryFrom($status);
        }

        $games = $this->gameRepository->findBySessionId($sessionId, $status);

        return $this->renderFrame('web/team/_includes/session_games_list.html.twig', [
            'games' => $games,
        ]);
    }
}
