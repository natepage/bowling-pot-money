<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\TeamMemberAccessLevelEnum;
use App\Infrastructure\Doctrine\Dbal\Type\TeamMemberAccessLevelType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'team_member_unique', columns: ['team_id', 'user_id'])]
class TeamMember extends AbstractEntity
{
    #[ORM\Column(type: TeamMemberAccessLevelType::NAME)]
    private TeamMemberAccessLevelEnum $accessLevel = TeamMemberAccessLevelEnum::MEMBER;

    #[ORM\Column(type: Types::BIGINT)]
    private string $balance = '0';

    #[ORM\Column(type: Types::STRING)]
    private string $currency;

    #[ORM\Column(type: Types::INTEGER)]
    private int $sequentialNumber = 0;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    private Team $team;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): TeamMember
    {
        $this->balance = $balance;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): TeamMember
    {
        $this->currency = $currency;
        return $this;
    }

    public function getAccessLevel(): TeamMemberAccessLevelEnum
    {
        return $this->accessLevel;
    }

    public function setAccessLevel(TeamMemberAccessLevelEnum $accessLevel): TeamMember
    {
        $this->accessLevel = $accessLevel;
        return $this;
    }

    public function setSequentialNumber(int $sequentialNumber): TeamMember
    {
        $this->sequentialNumber = $sequentialNumber;
        return $this;
    }

    public function getSequentialNumber(): int
    {
        return $this->sequentialNumber;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): TeamMember
    {
        $this->team = $team;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): TeamMember
    {
        $this->user = $user;
        return $this;
    }

    protected function toString(): ?string
    {
        return null;
    }
}