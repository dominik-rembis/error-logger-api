<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Dto;

use User\Aggregate\Domain\ObjectValue\AggregateUuid;

final class AggregateAccountRow
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $surname
    ) {}

    public function getUuid(): string
    {
        return AggregateUuid::fromBinary($this->uuid)->toRfc4122();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }
}