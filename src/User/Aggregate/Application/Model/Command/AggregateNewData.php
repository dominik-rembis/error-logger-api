<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;

final class AggregateNewData implements CommandInterface
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly array $accountUuids = []
    ) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAccountUuids(): array
    {
        return $this->accountUuids;
    }

    public function getLog(): string
    {
        return sprintf('Updating aggregate with uuid: %s', $this->uuid);
    }
}