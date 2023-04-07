<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Team;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class TeamRepository extends AbstractOptimizedDoctrineOrmRepository
{
    protected function getEntityClass(): string
    {
        return Team::class;
    }
}