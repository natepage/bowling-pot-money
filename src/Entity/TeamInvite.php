<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\ActorAwareInterface;
use App\Entity\Enum\TeamInviteStatusEnum;
use App\Entity\Enum\TeamMemberAccessLevelEnum;
use App\Entity\Mixin\ActorAwareTrait;
use App\Infrastructure\Doctrine\Dbal\Type\TeamInviteStatusType;
use App\Infrastructure\Doctrine\Dbal\Type\TeamMemberAccessLevelType;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Index(columns: ['email', 'team_id'], name: 'team_invite_email_team_idx')]
class TeamInvite extends AbstractEntity implements ActorAwareInterface
{
    private const DEFAULT_EXPIRATION_DAYS = 7;

    use ActorAwareTrait;

    #[ORM\Column(type: TeamMemberAccessLevelType::NAME)]
    private TeamMemberAccessLevelEnum $accessLevel = TeamMemberAccessLevelEnum::MEMBER;

    #[ORM\Column(type: Types::STRING)]
    private string $email;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected CarbonImmutable $expiresAt;

    #[ORM\Column(type: TeamInviteStatusType::NAME)]
    private TeamInviteStatusEnum $status = TeamInviteStatusEnum::CREATED;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'members')]
    private Team $team;

    public function __construct()
    {
        $this->expiresAt = CarbonImmutable::now()->addDays(self::DEFAULT_EXPIRATION_DAYS);
    }

    public function getAccessLevel(): TeamMemberAccessLevelEnum
    {
        return $this->accessLevel;
    }

    public function setAccessLevel(TeamMemberAccessLevelEnum $accessLevel): TeamInvite
    {
        $this->accessLevel = $accessLevel;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): TeamInvite
    {
        $this->email = $email;
        return $this;
    }

    public function getExpiresAt(): CarbonImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(CarbonImmutable $expiresAt): TeamInvite
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function getStatus(): TeamInviteStatusEnum
    {
        return $this->status;
    }

    public function setStatus(TeamInviteStatusEnum $status): TeamInvite
    {
        $this->status = $status;
        return $this;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): TeamInvite
    {
        $this->team = $team;
        return $this;
    }

    protected function toString(): ?string
    {
        return null;
    }
}