<?php
declare(strict_types=1);

namespace App\Entity\Enum;

enum TeamInviteStatusEnum: string
{
    case ACCEPTED = 'accepted';
    case CREATED = 'created';
    case CANCELLED = 'cancelled';
    case EMAIL_SENT = 'email_sent';
    case EXPIRED = 'expired';
}
