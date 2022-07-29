<?php

declare(strict_types=1);

namespace User\Data\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class UserDataModel implements CommandInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
        private readonly ?string $uuid = null
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

    public function getUuid(): ?UserDataUuid
    {
        return $this->uuid ? UserDataUuid::fromString($this->uuid) : null;
    }

    public function getLog(): string
    {
        return sprintf('Processing user data about the e-mail address: %s', $this->email);
    }
}