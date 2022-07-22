<?php

declare(strict_types=1);

namespace Shared\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;

final class SymfonyKernel extends Kernel
{
    use MicroKernelTrait { configureContainer as baseContainerConfiguration; }

    private function configureContainer(
        ContainerConfigurator $container,
        LoaderInterface $loader,
        ContainerBuilder $builder
    ): void
    {
        $this->baseContainerConfiguration($container, $loader, $builder);
        $container->import(sprintf('%s/services/*.yaml', $this->getConfigDir()));
    }
}