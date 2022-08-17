<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Dto;

use User\Aggregate\Domain\ObjectValue\AggregateUuid;

final class AggregateSummaryRow
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly int $accountCount
    ) {}

    public function getUuid(): string
    {
        return AggregateUuid::fromBinary($this->uuid)->toRfc4122();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAccountCount(): int
    {
        return $this->accountCount;
    }
}