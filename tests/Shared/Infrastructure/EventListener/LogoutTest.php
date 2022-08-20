<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener;

use Shared\Infrastructure\EventListener\Security\Logout;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final class LogoutTest extends BaseTestCase
{
    public function testCaseOfResponseHasBeenSet(): void
    {
        $mock = self::createMock(LogoutEvent::class);
        $mock->expects($this->once())
            ->method('setResponse')
            ->with(self::callback(fn(object $object): bool => $object instanceof JsonResponse));

        (new Logout())->onLogout($mock);
    }
}