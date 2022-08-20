<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener\Security;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

final class FailureLogin
{
    public function onFailure(LoginFailureEvent $event): void
    {
        $event->setResponse(
            new JsonResponse('Invalid credentials.', 401)
        );
    }
}