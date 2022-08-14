<?php

declare(strict_types=1);

namespace User\Data\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class NewAccountData implements CommandInterface
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
    ) {}

    public function getUuid(): UserDataUuid
    {
        return UserDataUuid::fromString($this->uuid);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
        ];
    }

    public function getLog(): string
    {
        return sprintf('Updating account data about uuid: %s', $this->uuid);
    }
}