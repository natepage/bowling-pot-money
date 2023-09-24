<?php

declare(strict_types=1);

namespace App\Form\Dto;

final class AchievementAssignDto
{
    private ?string $achievementId = null;

    private ?string $teamMemberId = null;

    public function getAchievementId(): ?string
    {
        return $this->achievementId;
    }

    public function setAchievementId(?string $achievementId): AchievementAssignDto
    {
        $this->achievementId = $achievementId;
        return $this;
    }

    public function getTeamMemberId(): ?string
    {
        return $this->teamMemberId;
    }

    public function setTeamMemberId(?string $teamMemberId): AchievementAssignDto
    {
        $this->teamMemberId = $teamMemberId;
        return $this;
    }
}
