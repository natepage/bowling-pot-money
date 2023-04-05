<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class UserRepository extends AbstractOptimizedDoctrineOrmRepository
{
    public function findOneByEmail(string $email): ?User
    {
        return $this->getRepository()->findOneBy(['email' => $email]);
    }

    protected function getEntityClass(): string
    {
        return User::class;
    }
}