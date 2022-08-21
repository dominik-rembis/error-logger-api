<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class TokenInvalid
{
    public function onInvalid(JWTInvalidEvent $event): void
    {
        $event->setResponse(
            new JsonResponse(
                $event->getException()->getMessage(),
                $event->getResponse()->getStatusCode()
            )
        );
    }
}