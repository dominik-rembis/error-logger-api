<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener\Security;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

final class SuccessLogin
{
    private const AUTHORIZATION_PATH = '/login';

    public function onSuccess(LoginSuccessEvent $event): void
    {
        if (self::supports($event)) {
            $event->setResponse(
                new JsonResponse([
                    'role' => current($event->getAuthenticatedToken()->getRoleNames()),
                    ...json_decode($event->getResponse()->getContent() ?: '', true)
                ])
            );
        }
    }

    private static function supports(LoginSuccessEvent $event): bool
    {
        return $event->getRequest()->getRequestUri() === self::AUTHORIZATION_PATH;
    }
}