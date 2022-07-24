<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Test;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseKernelTestCase extends KernelTestCase
{
    protected static ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        self::$container = self::bootKernel()->getContainer();
    }
}