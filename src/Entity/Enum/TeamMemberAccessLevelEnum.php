<?php
declare(strict_types=1);

namespace App\Entity\Enum;

enum TeamMemberAccessLevelEnum: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
}
