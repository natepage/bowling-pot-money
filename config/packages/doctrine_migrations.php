<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine_migrations', [
        'custom_template' => '%kernel.project_dir%/migrations/migration.tpl',
        'migrations_paths' => [
            'DoctrineMigrations' => '%kernel.project_dir%/migrations',
        ],
        'enable_profiler' => false,
    ]);
};
