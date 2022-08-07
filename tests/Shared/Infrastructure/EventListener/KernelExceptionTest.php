<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class KernelExceptionTest extends BaseTestCase
{
    public function testCaseOfNoResponseWhenNoSuitableStrategyWasFound(): void
    {
        $exceptionEvent = $this->getExceptionEventMock(new \Exception('example message', 500));

        (new KernelException())->onKernelException($exceptionEvent);

        $this->assertNull($exceptionEvent->getResponse());
    }

    public function testCaseOfResponsiveSetupWhereStrategiesWereFound(): void
    {
        $exceptionEvent = $this->getExceptionEventMock(
            new \Exception('example message', 500, new NotFound())
        );

        (new KernelException())->onKernelException($exceptionEvent);

        $this->assertInstanceOf(JsonResponse::class, $exceptionEvent->getResponse());
    }

    private function getExceptionEventMock(\Exception $exception): ExceptionEvent
    {
        return new ExceptionEvent(
            self::createMock(HttpKernelInterface::class),
            Request::createFromGlobals(),
            1,
            $exception
        );
    }
}