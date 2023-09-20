<?php
declare(strict_types=1);

namespace App\Session;

use App\Common\Traits\DealsWithSession;
use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use App\Entity\Team;
use App\Repository\SessionRepository;

final class SessionManager
{
    use DealsWithSession;

    public function __construct(private readonly SessionRepository $sessionRepository)
    {
    }

    public function closeSession(Session $session): Session
    {
        $this->checkCanBeClosed($session);

        $session = $this->doCloseSession($session);

        $this->sessionRepository->save($session);
        $this->sessionRepository->flush();

        return $session;
    }

    public function getCurrentSession(Team $team): ?Session
    {
        return $this->sessionRepository->findOpenedByTeamId($team->getId());
    }

    public function openSession(Team $team): Session
    {
        $currentSession = $this->getCurrentSession($team);
        if ($currentSession !== null) {
            try {
                $this->checkCanBeClosed($currentSession);
                $this->doCloseSession($currentSession);
            } catch (\Throwable $throwable) {
                throw new \InvalidArgumentException(
                    'There is already opened session for this team.',
                    $throwable->getCode(),
                    $throwable
                );
            }
        }

        $session = (new Session())->setTeam($team);

        $this->sessionRepository->save($session);
        $this->sessionRepository->flush();

        return $session;
    }

    private function checkCanBeClosed(Session $session): void
    {
        $this->ensureSessionOpened($session);

        // TODO: Check for active games once implemented
    }

    private function doCloseSession(Session $session): Session
    {
        return $session->setStatus(SessionStatusEnum::CLOSED);
    }
}