<?php

declare(strict_types=1);

namespace App\Form\Dto;

final class GameSetScoreDto
{
    private ?int $score = null;

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): GameSetScoreDto
    {
        $this->score = $score;
        return $this;
    }
}