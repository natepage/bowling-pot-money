<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Type;

use App\Entity\Enum\GameStatusEnum;

final class GameStatusType extends AbstractStringBackedEnumType
{
    public const NAME = 'game_status';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getEnumClass(): string
    {
        return GameStatusEnum::class;
    }
}