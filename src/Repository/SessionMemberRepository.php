<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\SessionMember;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class SessionMemberRepository extends AbstractOptimizedDoctrineOrmRepository
{
    /**
     * @return \App\Entity\SessionMember[]
     */
    public function findBySessionId(string $sessionId): array
    {
        return $this->createQueryBuilder('sm')
            ->addSelect('tm')
            ->join('sm.teamMember', 'tm')
            ->where('sm.session = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->getQuery()
            ->getResult();
    }

    protected function getEntityClass(): string
    {
        return SessionMember::class;
    }
}