<?php
declare(strict_types=1);

namespace App\Team\TeamInvite;

use App\Entity\TeamInvite;
use App\Repository\TeamInviteRepository;

final class TeamInvitePersister
{
    public function __construct(private readonly TeamInviteRepository $teamInviteRepository)
    {
    }

    public function persist(TeamInvite $teamInvite): TeamInvite
    {
        $this->teamInviteRepository->invalidateExistingInvites(
            $teamInvite->getTeam()->getId(),
            $teamInvite->getEmail()
        );

        $this->teamInviteRepository->save($teamInvite);
        $this->teamInviteRepository->flush();

        return $teamInvite;
    }
}