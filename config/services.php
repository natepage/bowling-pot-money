<?php

declare(strict_types=1);

use AsyncAws\DynamoDb\DynamoDbClient;
use AsyncAws\DynamoDbSession\SessionHandler as DynamoDbSessionHandler;
use Symfony\Bridge\Monolog\Processor\WebProcessor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([
            __DIR__ . '/../src/**/Config/*.php',
            __DIR__ . '/../src/DependencyInjection/',
            __DIR__ . '/../src/Entity/',
            __DIR__ . '/../src/Infrastructure/Bref/',
            __DIR__ . '/../src/Infrastructure/HttpKernel/Kernel.php',
    ]);

    // DynamoDB session handler
    $services->set(DynamoDbClient::class);
    $services
        ->set(DynamoDbSessionHandler::class)
        ->arg('$options', ['table_name' => 'sessions']);

    // Log processor from symfony/monolog-bridge
    $services->set(WebProcessor::class);
};
