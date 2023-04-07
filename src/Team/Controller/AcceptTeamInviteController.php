<?php
declare(strict_types=1);

namespace App\Team\Controller;

use App\Repository\TeamInviteRepository;
use App\Team\TeamInvite\TeamInviteAcceptor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/team-invites/{teamInviteId}/accept', name: 'team_invite_accept', methods: ['GET'])]
final class AcceptTeamInviteController extends AbstractController
{
    public function __construct(
        private readonly TeamInviteAcceptor $teamInviteAcceptor,
        private readonly TeamInviteRepository $teamInviteRepository
    ) {
    }

    public function __invoke(string $teamInviteId): RedirectResponse
    {
        // TODO: Deal with invalid teamInviteId, not found
        $teamInvite = $this->teamInviteRepository->find($teamInviteId);
        $user = $this->getUser()->getDbUser();

        // TODO: Deal with exceptions from acceptor
        $this->teamInviteAcceptor->accept($user, $teamInvite);

        // TODO: redirect to better page for facing users
        return $this->redirectToRoute('admin_index');
    }
}