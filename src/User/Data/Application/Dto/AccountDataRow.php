<?php

declare(strict_types=1);

namespace User\Data\Application\Dto;

use User\Data\Domain\ObjectValue\UserDataUuid;

final class AccountDataRow
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $surname,
        private readonly int $status,
        private readonly ?string $email = null
    ) {}

    public function getUuid(): string
    {
        return UserDataUuid::fromBinary($this->uuid)->toRfc4122();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getStatus(): bool
    {
        return (bool) $this->status;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}