<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Type;

use App\Entity\Enum\TeamMemberAccessLevelEnum;

final class TeamMemberAccessLevelType extends AbstractStringBackedEnumType
{
    public const NAME = 'team_member_access_level';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getEnumClass(): string
    {
        return TeamMemberAccessLevelEnum::class;
    }
}