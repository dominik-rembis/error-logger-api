<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Shared\Application\Factory\ResponseContentFactory;

final class SuccessAuthentication
{
    public function onSuccess(AuthenticationSuccessEvent $event): void
    {
        $event->setData(
            ResponseContentFactory::create(
                [
                    'role' => current($event->getUser()->getRoles()),
                    ...$event->getData()
                ],
                $event->getResponse()->getStatusCode()
            )
        );
    }
}