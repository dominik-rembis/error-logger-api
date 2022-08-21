<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class TokenExpired
{
    public function onExpired(JWTExpiredEvent $event): void
    {
        $event->setResponse(
            new JsonResponse(
                'Expired JWT Token.',
                $event->getResponse()->getStatusCode()
            )
        );
    }
}