<?php

declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $imports = [
        'admin' => 'Admin',
        'api' => 'Api',
        'web' => 'Web',
    ];

    foreach ($imports as $group => $folder) {
        $importConfigurator = $routingConfigurator->import([
            'path' => \sprintf('../src/Controller/%s/', $folder),
            'namespace' => \sprintf('App\Controller\%s', $folder),
        ], 'attribute');

        if ($group === 'api') {
            $importConfigurator->prefix('/api');
        }
    }

    $routingConfigurator
        ->add('web_homepage', '/')
        ->controller(RedirectController::class)
        ->defaults([
            'route' => 'teams_list',
        ]);
};
