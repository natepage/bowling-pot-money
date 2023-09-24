<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Repository\SessionMemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}/achievements/assign/members',
    name: '_frame_achievement_assign_member',
    methods: [Request::METHOD_GET]
)]
final class AchievementAssignMembersListController extends AbstractTurboFrameController
{
    public function __construct(
        private readonly SessionMemberRepository $sessionMemberRepository,
    ) {
    }

    public function __invoke(string $sessionId): Response
    {
        $sessionMembers = $this->sessionMemberRepository->findBySessionId($sessionId);

        return $this->renderFrame('web/team/_includes/sessionMembers_forAchievement_list.html.twig', [
            'sessionMembers' => $sessionMembers,
        ]);
    }
}
