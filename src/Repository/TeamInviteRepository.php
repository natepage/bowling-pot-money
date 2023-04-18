<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Enum\TeamInviteStatusEnum;
use App\Entity\TeamInvite;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class TeamInviteRepository extends AbstractOptimizedDoctrineOrmRepository
{
    public function invalidateExistingInvites(string $teamId, string $email): void
    {
        $queryBuilder = $this->createQueryBuilder('ti');

        $queryBuilder
            ->update()
            ->set('ti.status', ':status')
            ->where('ti.email = :email')
            ->andWhere('ti.team = :teamId')
            ->andWhere($queryBuilder->expr()->in('ti.status', [
                TeamInviteStatusEnum::CREATED->value,
                TeamInviteStatusEnum::EMAIL_SENT->value,
            ]))
            ->setParameter('status', TeamInviteStatusEnum::CANCELLED->value)
            ->setParameter('email', $email)
            ->setParameter('teamId', $teamId)
            ->getQuery()
            ->execute();
    }

    protected function getEntityClass(): string
    {
        return TeamInvite::class;
    }
}