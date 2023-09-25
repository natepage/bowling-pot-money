<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Type;

use App\Entity\Enum\FinancialActivityTypeEnum;

final class FinancialActivityTypeType extends AbstractStringBackedEnumType
{
    public const NAME = 'financial_activity_type';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getEnumClass(): string
    {
        return FinancialActivityTypeEnum::class;
    }
}