<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Security;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

final class SuccessAuthentication implements AuthenticationSuccessHandlerInterface
{
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        return new JsonResponse([
            'role' => current($token->getRoleNames())
        ]);
    }
}