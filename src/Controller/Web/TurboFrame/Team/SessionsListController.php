<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Repository\SessionRepository;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams/{teamId}/sessions', name: '_frame_sessions_list', methods: [Request::METHOD_GET])]
final class SessionsListController extends AbstractTurboFrameController
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly SessionRepository $sessionRepository,
    ) {
    }

    public function __invoke(string $teamId): Response
    {
        $team = $this->teamRepository->find($teamId);
        $sessions = $this->sessionRepository->findByTeamId($teamId);

        return $this->renderFrame('web/team/_includes/sessions_list.html.twig', [
            'team' => $team,
            'sessions' => $sessions,
        ]);
    }
}
