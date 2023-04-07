<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Type;

use App\Entity\Enum\TeamInviteStatusEnum;

final class TeamInviteStatusType extends AbstractStringBackedEnumType
{
    public const NAME = 'team_invite_status';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getEnumClass(): string
    {
        return TeamInviteStatusEnum::class;
    }
}