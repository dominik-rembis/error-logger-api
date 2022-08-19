<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Security;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final class FailureAuthenticationTest extends BaseTestCase
{
    public function testCaseOfReturningResponse(): void
    {
        $requestMock = self::createMock(Request::class);
        $authenticationException = self::createMock(AuthenticationException::class);

        $result = (new FailureAuthentication)->onAuthenticationFailure($requestMock, $authenticationException);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(401, $result->getStatusCode());
        $this->assertSame('{"status":401,"message":"Invalid credentials."}', $result->getContent());
    }
}