<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Security;

use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserProvider extends EntityUserProvider
{
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = parent::loadUserByIdentifier($identifier);

        if (!$user->isActive()) {
            throw new AccessDeniedException();
        }

        return $user;
    }
}