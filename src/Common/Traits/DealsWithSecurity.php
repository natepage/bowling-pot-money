<?php
declare(strict_types=1);

namespace App\Common\Traits;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

trait DealsWithSecurity
{
    protected function getDbUser(Security $security): ?User
    {
        return $security->getUser()?->getDbUser();
    }
}