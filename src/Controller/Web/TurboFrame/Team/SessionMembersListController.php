<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Repository\SessionMemberRepository;
use App\Repository\SessionRepository;
use App\Repository\TeamMemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}/members',
    name: '_frame_session_members_list',
    methods: [Request::METHOD_GET]
)]
final class SessionMembersListController extends AbstractTurboFrameController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly SessionMemberRepository $sessionMemberRepository,
    ) {
    }

    public function __invoke(string $teamId, string $sessionId): Response
    {
        $session = $this->sessionRepository->findOneByIdAndTeamId($sessionId, $teamId);
        $sessionMembers = $this->sessionMemberRepository->findBySessionId($session->getId());

        return $this->renderFrame('web/team/_includes/sessionMembers_list.html.twig', [
            'sessionMembers' => $sessionMembers,
        ]);
    }
}
