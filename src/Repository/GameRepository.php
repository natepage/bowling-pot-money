<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Enum\GameStatusEnum;
use App\Entity\Game;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class GameRepository extends AbstractOptimizedDoctrineOrmRepository
{
    public function closeFinishedGamesBySessionId(string $sessionId): void
    {
        $queryBuilder = $this->createQueryBuilder('g');
        $expr = $queryBuilder->expr();

        $queryBuilder
            ->update()
            ->set('g.status', ':setStatus')
            ->where($expr->eq('g.session', ':sessionId'))
            ->andWhere($expr->eq('g.status', ':whereStatus'))
            ->andWhere($expr->isNotNull('g.score'))
            ->setParameter('sessionId', $sessionId)
            ->setParameter('setStatus', GameStatusEnum::CLOSED)
            ->setParameter('whereStatus', GameStatusEnum::OPENED)
            ->getQuery()
            ->execute();
    }

    /**
     * @return \App\Entity\Game[]
     */
    public function findBySessionId(string $sessionId): array
    {
        return $this->getRepository()->createQueryBuilder('g')
            ->where('g.session = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->orderBy('g.createdAt', 'desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return \App\Entity\Game[]
     */
    public function findUnfinishedGamesBySessionId(string $sessionId): array
    {
        $queryBuilder = $this->createQueryBuilder('g');
        $expr = $queryBuilder->expr();

        return $queryBuilder
            ->where($expr->eq('g.session', ':sessionId'))
            ->andWhere($expr->eq('g.status', ':status'))
            ->andWhere($expr->isNull('g.score'))
            ->setParameter('sessionId', $sessionId)
            ->setParameter('status', GameStatusEnum::OPENED)
            ->getQuery()
            ->getResult();
    }

    protected function getEntityClass(): string
    {
        return Game::class;
    }
}