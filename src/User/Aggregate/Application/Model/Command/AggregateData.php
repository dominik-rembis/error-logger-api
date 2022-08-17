<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;

final class AggregateData implements CommandInterface
{
    public function __construct(
        private readonly string $name,
        private readonly array $accountUuids = []
    ) {}

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
        return 'Creating a new account aggregate';
    }
}