<?php
declare(strict_types=1);

namespace App\Entity\Enum;

enum FinancialActivityTypeEnum: string
{
    case ACHIEVEMENT_ASSIGN = 'achievement_assign';

    case PAYMENT_CASH = 'payment_cash';
}
