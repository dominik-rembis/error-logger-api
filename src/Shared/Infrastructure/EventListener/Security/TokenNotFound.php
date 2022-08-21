<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class TokenNotFound
{
    public function onNotFound(JWTNotFoundEvent $event): void
    {
        $event->setResponse(
            new JsonResponse(
                $event->getException()->getMessage(),
                $event->getResponse()->getStatusCode()
            )
        );
    }
}