<?php
declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Repository\TeamMemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams', name: 'teams_list', methods: [Request::METHOD_GET])]
final class ListController extends AbstractWebController
{
    public function __construct(
        private readonly TeamMemberRepository $teamMemberRepository
    ) {
    }

    public function __invoke(): Response
    {
        $user = $this->getCurrentUser();
        $teamMembers = $this->teamMemberRepository->findByUserIdWithTeam($user->getId());

        return $this->render('web/turboFrame/team/list.html.twig', [
            'teamMembers' => $teamMembers,
        ]);
    }
}