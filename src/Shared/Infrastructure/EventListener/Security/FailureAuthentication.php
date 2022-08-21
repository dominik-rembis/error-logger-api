<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class FailureAuthentication
{
    public function onFailure(AuthenticationFailureEvent $event): void
    {
        $event->setResponse(
            new JsonResponse(
                $event->getException()->getMessage(),
                $event->getResponse()->getStatusCode()
            )
        );
    }
}