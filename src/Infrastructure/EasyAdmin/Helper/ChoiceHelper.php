<?php
declare(strict_types=1);

namespace App\Infrastructure\EasyAdmin\Helper;

final class ChoiceHelper
{
    public static function formatForAdminSelect(array $choices): array
    {
        $choices = \array_map(static function ($choice) {
            if (\interface_exists(\BackedEnum::class) && $choice instanceof \BackedEnum) {
                return $choice->value;
            }

            return $choice;
        }, $choices);

        return \array_combine($choices, $choices);
    }
}
