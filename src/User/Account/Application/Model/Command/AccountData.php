<?php

declare(strict_types=1);

namespace User\Account\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;
use User\Account\Domain\ObjectValue\Role;

final class AccountData implements CommandInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
        private readonly string $role
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): Role
    {
        return Role::from($this->role);
    }

    public function getLog(): string
    {
        return sprintf('Creating user account about the e-mail address: %s', $this->email);
    }
}