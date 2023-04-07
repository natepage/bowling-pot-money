<?php
declare(strict_types=1);

namespace App\Team\TeamInvite;

use App\Entity\Enum\TeamInviteStatusEnum;
use App\Entity\TeamInvite;
use App\Entity\TeamMember;
use App\Entity\User;
use App\Repository\TeamMemberRepository;
use App\Team\Exception\TeamInviteEmailMismatchException;
use App\Team\Exception\TeamInviteInvalidStatusException;

final class TeamInviteAcceptor
{
    public function __construct(private readonly TeamMemberRepository $teamMemberRepository)
    {
    }

    public function accept(User $user, TeamInvite $teamInvite): void
    {
        if ($teamInvite->getStatus() !== TeamInviteStatusEnum::EMAIL_SENT) {
            throw new TeamInviteInvalidStatusException(\sprintf(
                'Team invite with id "%s" has invalid status "%s"',
                $teamInvite->getId(),
                $teamInvite->getStatus()->value
            ));
        }

        if ($teamInvite->getExpiresAt()->isPast()) {
            throw new TeamInviteInvalidStatusException(\sprintf(
                'Team invite with id "%s" has expired',
                $teamInvite->getId()
            ));
        }

        if ($user->getEmail() !== $teamInvite->getEmail()) {
            throw new TeamInviteEmailMismatchException(\sprintf(
                'Team invite with id "%s" has email "%s" but user with id "%s" has email "%s"',
                $teamInvite->getId(),
                $teamInvite->getEmail(),
                $user->getId(),
                $user->getEmail()
            ));
        }

        $teamInvite->setStatus(TeamInviteStatusEnum::ACCEPTED);

        $existingMember = $this->teamMemberRepository->findOneByTeamIdAndUserId(
            $teamInvite->getTeam()->getId(),
            $user->getId()
        );

        // If the user is already a member of the team, we don't need to do anything
        if ($existingMember === null) {
            $teamMember = (new TeamMember())
                ->setAccessLevel($teamInvite->getAccessLevel())
                ->setCurrency($teamInvite->getTeam()->getCurrency())
                ->setTeam($teamInvite->getTeam())
                ->setUser($user);

            $this->teamMemberRepository->save($teamMember);
        }

        $this->teamMemberRepository->flush();
    }
}