<?php
declare(strict_types=1);

namespace App\Infrastructure\Helper;

final class UrlHelper
{
    public static function urlSafeBase64Decode(string $input): string
    {
        $remainder = \strlen($input) % 4;

        if ($remainder) {
            $padLen = 4 - $remainder;
            $input .= \str_repeat('=', $padLen);
        }

        return \base64_decode(\strtr($input, '-_', '+/'));
    }

    public static function urlSafeBase64Encode(string $input): string
    {
        return \str_replace('=', '', \strtr(\base64_encode($input), '+/', '-_'));
    }
}