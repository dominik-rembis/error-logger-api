<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Dto;

final class AggregateDataRow
{
    public function __construct(
        private readonly string $name,
        private readonly array $accounts
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getAccounts(): array
    {
        return $this->accounts;
    }
}