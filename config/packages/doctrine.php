<?php

declare(strict_types=1);

use App\Infrastructure\Doctrine\Dbal\Type\CarbonImmutableType;
use App\Infrastructure\Doctrine\Dbal\Type\FinancialActivityTypeType;
use App\Infrastructure\Doctrine\Dbal\Type\GameStatusType;
use App\Infrastructure\Doctrine\Dbal\Type\SessionStatusType;
use App\Infrastructure\Doctrine\Dbal\Type\TeamInviteStatusType;
use App\Infrastructure\Doctrine\Dbal\Type\TeamMemberAccessLevelType;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'url' => '%env(resolve:DATABASE_URL)%',
            'types' => [
                GameStatusType::NAME => GameStatusType::class,
                FinancialActivityTypeType::NAME => FinancialActivityTypeType::class,
                SessionStatusType::NAME => SessionStatusType::class,
                Types::DATETIME_IMMUTABLE => CarbonImmutableType::class,
                TeamInviteStatusType::NAME => TeamInviteStatusType::class,
                TeamMemberAccessLevelType::NAME => TeamMemberAccessLevelType::class,
            ],
        ],
        'orm' => [
            'auto_generate_proxy_classes' => true,
            'enable_lazy_ghost_objects' => true,
            'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
            'auto_mapping' => true,
            'mappings' => [
                'App' => [
                    'is_bundle' => false,
                    'dir' => '%kernel.project_dir%/src/Entity',
                    'prefix' => 'App\Entity',
                    'alias' => 'App',
                ],
            ],
        ],
    ]);

    if ($containerConfigurator->env() === 'test') {
        $containerConfigurator->extension('doctrine', [
            'dbal' => [
                'dbname_suffix' => '_test%env(default::TEST_TOKEN)%',
            ],
        ]);
    }

    if ($containerConfigurator->env() === 'prod') {
        $containerConfigurator->extension('doctrine', [
            'orm' => [
                'auto_generate_proxy_classes' => false,
                'proxy_dir' => '%kernel.build_dir%/doctrine/orm/Proxies',
                'query_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.system_cache_pool',
                ],
                'result_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.result_cache_pool',
                ],
            ],
        ]);
        $containerConfigurator->extension('framework', [
            'cache' => [
                'pools' => [
                    'doctrine.result_cache_pool' => [
                        'adapter' => 'cache.app',
                    ],
                    'doctrine.system_cache_pool' => [
                        'adapter' => 'cache.system',
                    ],
                ],
            ],
        ]);
    }
};
