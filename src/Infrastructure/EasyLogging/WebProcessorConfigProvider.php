<?php
declare(strict_types=1);

namespace App\Infrastructure\EasyLogging;

use EonX\EasyLogging\Config\ProcessorConfig;
use EonX\EasyLogging\Interfaces\Config\ProcessorConfigProviderInterface;
use Symfony\Bridge\Monolog\Processor\WebProcessor;

final class WebProcessorConfigProvider implements ProcessorConfigProviderInterface
{
    public function __construct(private readonly WebProcessor $webProcessor)
    {
    }

    /**
     * @return iterable<\EonX\EasyLogging\Interfaces\Config\ProcessorConfigInterface>
     */
    public function processors(): iterable
    {
        yield ProcessorConfig::create($this->webProcessor);
    }
}
