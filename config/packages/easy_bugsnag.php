<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('easy_bugsnag', [
        'api_key' => '%env(BUGSNAG_API_KEY)%',
        'doctrine_dbal' => [
            'enabled' => false,
        ],
    ]);
};
