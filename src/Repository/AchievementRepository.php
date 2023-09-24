<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Achievement;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class AchievementRepository extends AbstractOptimizedDoctrineOrmRepository
{
    /**
     * @return \App\Entity\Achievement[]
     */
    public function findByTeamId(string $teamId): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.team = :teamId')
            ->setParameter('teamId', $teamId)
            ->orderBy('a.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneByIdAndTeamId(string $id, string $teamId): ?Achievement
    {
        $achievement = $this->getRepository()->find($id);

        if ($achievement instanceof Achievement === false || $achievement->getTeam()->getId() !== $teamId) {
            return null;
        }

        return $achievement;
    }

    protected function getEntityClass(): string
    {
        return Achievement::class;
    }
}