<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Security;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class SuccessAuthenticationTest extends BaseTestCase
{
    public function testCaseOfReturningResponse(): void
    {
        $requestMock = self::createMock(Request::class);
        $tokenInterface = self::createMock(TokenInterface::class);

        $result = (new SuccessAuthentication)->onAuthenticationSuccess($requestMock, $tokenInterface);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(200, $result->getStatusCode());
        $this->assertSame('{"status":200,"message":null}', $result->getContent());
    }
}