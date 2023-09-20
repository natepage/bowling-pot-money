<?php
declare(strict_types=1);

namespace App\Controller\Web\Team;

use App\Common\Traits\DealsWithSecurity;
use App\Controller\Web\AbstractWebController;
use App\Repository\SessionRepository;
use App\Repository\TeamInviteRepository;
use App\Repository\TeamMemberRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams/{teamId}', name: 'teams_show', methods: ['GET'])]
final class ShowController extends AbstractWebController
{
    use DealsWithSecurity;

    public function __construct(
        private readonly Security $security,
        private readonly SessionRepository $sessionRepository,
        private readonly TeamInviteRepository $teamInviteRepository,
        private readonly TeamMemberRepository $teamMemberRepository
    ) {
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function doInvoke(Request $request): Response
    {
        $teamId = $request->attributes->get('teamId');
        $sessions = $this->sessionRepository->findByTeamId($teamId);
        $teamMembers = $this->teamMemberRepository->findByTeamIdWithTeamAndUser($teamId);
        $teamInvites = $this->teamInviteRepository->findByTeamId($teamId);

        if ($this->canAccessTeam($teamMembers) === false) {
            // TODO: Handle no access to team
        }

        return $this->render('web/turboFrame/team/show.html.twig', [
            'sessions' => $sessions,
            'team' => \current($teamMembers)->getTeam(),
            'teamMembers' => $teamMembers,
            'teamInvites' => $teamInvites,
        ]);
    }

    /**
     * @param \App\Entity\TeamMember[] $teamMembers
     */
    private function canAccessTeam(array $teamMembers): bool
    {
        $user = $this->getDbUser($this->security);

        foreach ($teamMembers as $teamMember) {
            if ($teamMember->getUser()->getId() === $user->getId()) {
                return true;
            }
        }

        return false;
    }
}