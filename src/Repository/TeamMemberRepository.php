<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TeamMember;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class TeamMemberRepository extends AbstractOptimizedDoctrineOrmRepository
{
    /**
     * @return \App\Entity\TeamMember[]
     */
    public function findByTeamId(string $teamId): array
    {
        return $this->getRepository()->findBy([
            'team' => $teamId,
        ]);
    }

    /**
     * @return \App\Entity\TeamMember[]
     */
    public function findByTeamIdWithTeamAndUser(string $teamId): array
    {
        return $this->getRepository()->createQueryBuilder('tm')
            ->addSelect(['t', 'u'])
            ->join('tm.team', 't')
            ->join('tm.user', 'u')
            ->where('tm.team = :teamId')
            ->setParameter('teamId', $teamId)
            ->getQuery()
            ->getResult();
    }

    public function findOneByTeamIdAndUserId(string $teamId, string $userId): ?TeamMember
    {
        return $this->getRepository()->findOneBy([
            'team' => $teamId,
            'user' => $userId,
        ]);
    }

    /**
     * @return \App\Entity\TeamMember[]
     */
    public function findByUserIdWithTeam(string $userId): array
    {
        return $this->getRepository()->createQueryBuilder('tm')
            ->addSelect('t')
            ->join('tm.team', 't')
            ->where('tm.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    protected function getEntityClass(): string
    {
        return TeamMember::class;
    }
}