<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Security;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

final class FailureAuthentication implements AuthenticationFailureHandlerInterface
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse('Invalid credentials.', 401);
    }
}