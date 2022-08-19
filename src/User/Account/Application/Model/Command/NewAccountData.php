<?php

declare(strict_types=1);

namespace User\Account\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\ObjectValue\Role;

final class NewAccountData implements CommandInterface
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $surname,
        private readonly ?string $email = null,
        private readonly ?string $role = null
    ) {}

    public function getUuid(): AccountUuid
    {
        return AccountUuid::fromString($this->uuid);
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'role' => Role::tryFrom($this->role ?? '')
        ]);
    }

    public function getLog(): string
    {
        return sprintf('Updating account data about uuid: %s', $this->uuid);
    }
}