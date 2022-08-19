<?php

declare(strict_types=1);

namespace User\Account\Infrastructure\Bridge;

use Shared\Domain\Entity\AggregateRoot;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Account\Domain\ObjectValue\Role;

/**
 * @property string $email
 * @property array $roles
 * @property string $password
 */
abstract class Security extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return array_unique($this->roles ?? [Role::DEVELOPER]);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function eraseCredentials(): void
    {
        $this->password = '';
    }

    public function isActive(): bool
    {
        return false;
    }
}