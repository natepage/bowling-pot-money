<?php
declare(strict_types=1);

namespace App\Session;

use App\Common\Traits\DealsWithSession;
use App\Entity\Session;
use App\Entity\SessionMember;
use App\Repository\TeamMemberRepository;

final class SessionMemberManager
{
    use DealsWithSession;

    public function __construct(
        private readonly TeamMemberRepository $teamMemberRepository
    ) {
    }

    public function addMembersByIds(Session $session, array $teamMemberIds): array
    {
        $this->ensureSessionOpened($session);

        $count = \count($teamMemberIds);
        if (Session::MIN_MEMBERS > $count || Session::MAX_MEMBERS < $count) {
            throw new \InvalidArgumentException(\sprintf(
                'Session must have between %d and %d members. %d given.',
                Session::MIN_MEMBERS,
                Session::MAX_MEMBERS,
                $count
            ));
        }

        $teamMembers = $this->teamMemberRepository->findByTeamId($session->getTeam()->getId());
        if (\count($teamMembers) !== $count) {
            throw new \InvalidArgumentException(
                'At least one of given team members is not a member of this session team.'
            );
        }

        $sessionMembers = [];
        foreach ($teamMembers as $teamMember) {
            $sessionMembers[] = (new SessionMember())
                ->setSession($session)
                ->setTeamMember($teamMember);
        }

        $this->teamMemberRepository->save($sessionMembers);
        $this->teamMemberRepository->flush();

        return $sessionMembers;
    }
}