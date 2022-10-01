<?php

declare(strict_types=1);

namespace Project\Application\Application\Model\Command;

use Project\Application\Domain\ObjectValue\AggregateUuid;
use Shared\Application\Model\Command\CommandInterface;

final class NewApplicationData implements CommandInterface
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $aggregateUuid
    ) {}
    
    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'aggregateUuid' => AggregateUuid::fromString($this->aggregateUuid)
        ];
    }

    public function getLog(): string
    {
        return sprintf('Updating project application data about uuid: %s', $this->uuid);
    }
}