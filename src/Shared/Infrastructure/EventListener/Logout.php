<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final class Logout
{
    public function onLogout(LogoutEvent $logoutEvent): void
    {
        $logoutEvent->setResponse(new JsonResponse());
    }
}