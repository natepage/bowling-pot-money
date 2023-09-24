<?php
declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Game\GameCreator;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}/games/new',
    name: 'teams_create_session_game',
    methods: [Request::METHOD_GET]
)]
final class GameCreateController extends AbstractWebController
{
    public function __construct(
        private readonly GameCreator $gameCreator,
        private readonly SessionRepository $sessionRepository,
    ) {
    }

    public function __invoke(string $teamId, string $sessionId): Response
    {
        $session = $this->sessionRepository->findOneByIdAndTeamId($sessionId, $teamId);

        try {
            $this->gameCreator->createGamesForSession($session);
        } catch (\Throwable $throwable) {
            $this->addFlash('danger', $throwable->getMessage());
        }

        return $this->redirectToRoute('teams_show_session', [
            'teamId' => $teamId,
            'sessionId' => $sessionId,
        ]);
    }
}