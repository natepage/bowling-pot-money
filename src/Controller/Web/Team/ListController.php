<?php
declare(strict_types=1);

namespace App\Controller\Web\Team;

use App\Common\Traits\DealsWithSecurity;
use App\Controller\Web\AbstractWebController;
use App\Repository\TeamMemberRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams', name: 'teams_list', methods: ['GET'])]
final class ListController extends AbstractWebController
{
    use DealsWithSecurity;

    public function __construct(
        private readonly Security $security,
        private readonly TeamMemberRepository $teamMemberRepository
    ) {
    }

    protected function doInvoke(Request $request): Response
    {
        $user = $this->getDbUser($this->security);
        $teamMembers = $this->teamMemberRepository->findByUserIdWithTeam($user->getId());

        return $this->render('web/turboFrame/team/list.html.twig', [
            'teamMembers' => $teamMembers,
        ]);
    }
}