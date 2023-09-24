<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Repository\TeamMemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams/{teamId}/members', name: '_frame_team_members_list', methods: [Request::METHOD_GET])]
final class TeamMembersListController extends AbstractTurboFrameController
{
    public function __construct(
        private readonly TeamMemberRepository $teamMemberRepository,
    ) {
    }

    public function __invoke(string $teamId): Response
    {
        $teamMembers = $this->teamMemberRepository->findByTeamIdWithTeamAndUser($teamId);

        return $this->renderFrame('web/team/_includes/teamMembers_list.html.twig', [
            'teamMembers' => $teamMembers,
        ]);
    }
}
