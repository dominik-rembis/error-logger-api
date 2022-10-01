<?php

declare(strict_types=1);

namespace Project\Application\Application\Dto;

use Project\Application\Domain\ObjectValue\AggregateUuid;
use Project\Application\Domain\ObjectValue\ApplicationUuid;

final class ApplicationDataRow
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly ?string $aggregateUuid = null
    ) {}

    public function getUuid(): string
    {
        return (string) ApplicationUuid::fromString($this->uuid);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAggregateUuid(): ?string
    {
        return $this->aggregateUuid ? (string) AggregateUuid::fromString($this->aggregateUuid) : null;
    }
}