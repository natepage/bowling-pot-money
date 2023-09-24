<?php

declare(strict_types=1);

namespace App\Game;

use App\Entity\Enum\GameStatusEnum;
use App\Entity\Game;
use App\Repository\GameRepository;

final class GameManager
{
    public const MIN_SCORE = 1;

    public const MAX_SCORE = 300;

    public function __construct(
        private readonly GameRepository $gameRepository,
    ) {
    }

    public function setScore(Game $game, int $score): Game
    {
        if ($game->isOpened() === false) {
            throw new \RuntimeException('Cannot set score for not opened game');
        }

        if ($score < self::MIN_SCORE || $score > self::MAX_SCORE) {
            throw new \RuntimeException(\sprintf(
                'Score must be within %d-%d, %d given',
                self::MIN_SCORE,
                self::MAX_SCORE,
                $score
            ));
        }

        $game->setScore($score);

        $this->gameRepository->flush();

        return $game;
    }
}