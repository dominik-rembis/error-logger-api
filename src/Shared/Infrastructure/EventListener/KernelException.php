<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener;

use Shared\Application\Policy\Exception\ExceptionPolicy;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class KernelException
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $policy = ExceptionPolicy::create($event->getThrowable());

        if ($policy) {
            $event->setResponse($policy->getResponse());
        }
    }
}