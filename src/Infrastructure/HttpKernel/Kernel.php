<?php

namespace App\Infrastructure\HttpKernel;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->getProjectDir() . '/config/{packages}/*.php');
        $container->import($this->getProjectDir() . '/config/{packages}/' . $this->environment . '/*.php');
        $container->import($this->getProjectDir() . '/config/{parameters}.php');
        $container->import($this->getProjectDir() . '/config/{parameters}_' . $this->environment . '.php');
        $container->import($this->getProjectDir() . '/config/{services}.php');
        $container->import($this->getProjectDir() . '/src/**/Config/*.php');
        $container->import($this->getProjectDir() . '/config/{services}_' . $this->environment . '.php');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->getProjectDir() . '/config/{routes}.php');
        $routes->import($this->getProjectDir() . '/config/{routes}/*.php');
        $routes->import($this->getProjectDir() . '/config/{routes}/' . $this->environment . '/*.php');
    }
}
