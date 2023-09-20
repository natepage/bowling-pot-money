<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Type;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;

final class CarbonImmutableType extends DateTimeImmutableType
{
    private const FORMAT_DB_TIMESTAMP_WO_TIMEZONE = 'TIMESTAMP(6) WITHOUT TIME ZONE';

    private const FORMAT_PHP_DATETIME = 'Y-m-d H:i:s.u';

    private static ?DateTimeZone $utc = null;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof DateTimeImmutable || $value instanceof DateTime) {
            return $value->setTimezone(self::getUtc())->format(self::FORMAT_PHP_DATETIME);
        }

        throw ConversionException::conversionFailedInvalidType($value, self::class, ['null', 'DateTimeInterface']);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CarbonImmutable
    {
        if ($value === null || $value instanceof CarbonImmutable) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return CarbonImmutable::instance($value);
        }

        $dateTime = DateTimeImmutable::createFromFormat(self::FORMAT_PHP_DATETIME, $value, self::getUtc());

        if ($dateTime === false) {
            $dateTime = \date_create_immutable($value, self::getUtc());
        }

        if ($dateTime instanceof DateTimeInterface) {
            return CarbonImmutable::instance($dateTime);
        }

        throw ConversionException::conversionFailedFormat($value, self::class, self::FORMAT_PHP_DATETIME);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return self::FORMAT_DB_TIMESTAMP_WO_TIMEZONE;
    }

    private static function getUtc(): DateTimeZone
    {
        return self::$utc ??= new DateTimeZone('UTC');
    }
}
