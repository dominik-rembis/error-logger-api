<?php

declare(strict_types=1);

namespace Shared\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel;

final class SymfonyKernel extends Kernel
{
    use MicroKernelTrait;
}
