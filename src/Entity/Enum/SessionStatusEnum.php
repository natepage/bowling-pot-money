<?php
declare(strict_types=1);

namespace App\Entity\Enum;

enum SessionStatusEnum: string
{
    case OPENED = 'opened';
    case CLOSED = 'closed';
}
