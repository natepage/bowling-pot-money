<?php
declare(strict_types=1);

namespace App\Form\Dto;

use App\Entity\Enum\TeamInviteStatusEnum;
use App\Entity\Enum\TeamMemberAccessLevelEnum;
use Carbon\CarbonImmutable;

final class TeamInviteCreateDto
{
    private TeamMemberAccessLevelEnum $accessLevel;

    private string $email;

    private ?CarbonImmutable $expiresAt = null;

    public function setAccessLevel(TeamMemberAccessLevelEnum $accessLevel): void
    {
        $this->accessLevel = $accessLevel;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAccessLevel(): TeamMemberAccessLevelEnum
    {
        return $this->accessLevel;
    }

    public function getExpiresAt(): ?CarbonImmutable
    {
        return $this->expiresAt;
    }
}