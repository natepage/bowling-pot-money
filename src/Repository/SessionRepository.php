<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class SessionRepository extends AbstractOptimizedDoctrineOrmRepository
{
    public const MAX_RESULTS = 5;

    /**
     * @return \App\Entity\Session[]
     */
    public function findByTeamId(string $teamId): array
    {
        return $this->getRepository()->createQueryBuilder('s')
            ->where('s.team = :teamId')
            ->setParameter('teamId', $teamId)
            ->orderBy('s.createdAt', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult();
    }

    public function findOneByIdAndTeamId(string $id, string $teamId): ?Session
    {
        $session = $this->getRepository()->find($id);

        if ($session instanceof Session === false || $session->getTeam()->getId() !== $teamId) {
            return null;
        }

        return $session;
    }

    public function findOpenedByTeamId(string $teamId): ?Session
    {
        return $this->getRepository()->findOneBy([
            'team' => $teamId,
            'status' => SessionStatusEnum::OPENED,
        ]);
    }

    protected function getEntityClass(): string
    {
        return Session::class;
    }
}