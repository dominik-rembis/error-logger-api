<?php

declare(strict_types=1);

namespace User\Account\Application\Dto;

use User\Account\Domain\ObjectValue\AccountUuid;

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
        return AccountUuid::fromBinary($this->uuid)->toRfc4122();
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