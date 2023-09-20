<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Type;

use App\Entity\Enum\SessionStatusEnum;

final class SessionStatusType extends AbstractStringBackedEnumType
{
    public const NAME = 'session_status';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getEnumClass(): string
    {
        return SessionStatusEnum::class;
    }
}