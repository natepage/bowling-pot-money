<?php
declare(strict_types=1);

namespace App\Infrastructure\EasyLogging;

use EonX\EasyLogging\Config\HandlerConfig;
use EonX\EasyLogging\Formatters\JsonFormatter;
use EonX\EasyLogging\Interfaces\Config\HandlerConfigProviderInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

final class HandlerConfigProvider implements HandlerConfigProviderInterface
{
    private const APP_CHANNEL = 'app';

    private const STREAM = 'php://stderr';

    /**
     * @return iterable<\EonX\EasyLogging\Interfaces\Config\HandlerConfigInterface>
     */
    public function handlers(): iterable
    {
        $formatter = new JsonFormatter();
        $appHandler = (new StreamHandler(self::STREAM, Logger::DEBUG))->setFormatter($formatter);
        $restHandler = (new StreamHandler(self::STREAM, Logger::WARNING))->setFormatter($formatter);

        $appHandlerConfig = new HandlerConfig($appHandler);
        $appHandlerConfig->channels([self::APP_CHANNEL]);

        $restHandlerConfig = new HandlerConfig($restHandler);
        $restHandlerConfig->exceptChannels([self::APP_CHANNEL]);

        yield $appHandlerConfig;
        yield $restHandlerConfig;
    }
}
