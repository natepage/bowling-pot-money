<?php
declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Repository\SessionRepository;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}',
    name: 'teams_show_session',
    methods: [Request::METHOD_GET]
)]
final class SessionShowController extends AbstractWebController
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly SessionRepository $sessionRepository,
    ) {
    }

    public function __invoke(Request $request, string $teamId, string $sessionId): Response
    {
        $team = $this->teamRepository->find($teamId);
        $session = $this->sessionRepository->find($sessionId);

        return $this->render('web/team/session_show.html.twig', [
            'session' => $session,
            'team' => $team,
        ]);
    }
}