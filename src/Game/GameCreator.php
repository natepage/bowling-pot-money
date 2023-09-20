<?php
declare(strict_types=1);

namespace App\Game;

use App\Common\Traits\DealsWithSession;
use App\Entity\Game;
use App\Entity\Session;
use App\Repository\GameRepository;
use App\Repository\SessionMemberRepository;

final class GameCreator
{
    use DealsWithSession;

    public function __construct(
        private readonly GameRepository $gameRepository,
        private readonly SessionMemberRepository $sessionMemberRepository
    ) {
    }

    /**
     * @return \App\Entity\Game[]
     */
    public function createGamesForSession(Session $session): array
    {
        $this->ensureSessionOpened($session);

        $unfinishedGames = $this->gameRepository->findUnfinishedGamesBySessionId($session->getId());
        if (\count($unfinishedGames) > 0) {
            throw new \RuntimeException('Cannot create new games while there are unfinished games.');
        }

        // Close finished games
        $this->gameRepository->closeFinishedGamesBySessionId($session->getId());

        // Create new games
        $sessionMembers = $this->sessionMemberRepository->findBySessionId($session->getId());
        $games = [];

        foreach ($sessionMembers as $sessionMember) {
            $games[] = (new Game())
                ->setSession($session)
                ->setTeamMember($sessionMember->getTeamMember());
        }

        $this->gameRepository->save($games);
        $this->gameRepository->flush();

        return $games;
    }
}