<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TeamMember;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class TeamMemberRepository extends AbstractOptimizedDoctrineOrmRepository
{
    public function findOneByTeamIdAndUserId(string $teamId, string $userId): ?TeamMember
    {
        return $this->getRepository()->findOneBy([
            'team' => $teamId,
            'user' => $userId,
        ]);
    }

    protected function getEntityClass(): string
    {
        return TeamMember::class;
    }
}