<?php

declare(strict_types=1);

use App\Infrastructure\Bref\AdminContextAsTwigGlobalListener;
use App\Infrastructure\EasyAdmin\Asset\PackageDecorator;
use AsyncAws\DynamoDb\DynamoDbClient;
use AsyncAws\DynamoDbSession\SessionHandler as DynamoDbSessionHandler;
use EasyCorp\Bundle\EasyAdminBundle\Asset\AssetPackage;
use Symfony\Bridge\Monolog\Processor\WebProcessor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

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
            __DIR__ . '/../src/Infrastructure/Bref/Runtime/',
            __DIR__ . '/../src/Infrastructure/HttpKernel/Kernel.php',
    ]);

    // DynamoDB session handler
    $services->set(DynamoDbClient::class);
    $services
        ->set(DynamoDbSessionHandler::class)
        ->arg('$options', ['table_name' => 'sessions']);

    // Log processor from symfony/monolog-bridge
    $services->set(WebProcessor::class);

    // Prefix easy-admin assets with public for CloudFront
    $services
        ->set(PackageDecorator::class)
        ->decorate(AssetPackage::class)
        ->arg('$decorated', service('.inner'));

    // Fix easy-admin in twig
    $services
        ->set(AdminContextAsTwigGlobalListener::class)
        ->tag('kernel.event_listener', [
            'priority' => -100,
        ]);
};
