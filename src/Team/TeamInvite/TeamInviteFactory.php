<?php
declare(strict_types=1);

namespace App\Team\TeamInvite;

use App\Entity\Enum\TeamMemberAccessLevelEnum;
use App\Entity\Team;
use App\Entity\TeamInvite;
use Carbon\CarbonImmutable;

final class TeamInviteFactory
{
    public function create(
        Team $team,
        string $email,
        TeamMemberAccessLevelEnum $accessLevel,
        ?CarbonImmutable $expiresAt = null
    ): TeamInvite {
        $teamInvite = (new TeamInvite())
            ->setAccessLevel($accessLevel)
            ->setEmail($email)
            ->setTeam($team);

        if ($expiresAt !== null) {
            $teamInvite->setExpiresAt($expiresAt);
        }

        return $teamInvite;
    }
}