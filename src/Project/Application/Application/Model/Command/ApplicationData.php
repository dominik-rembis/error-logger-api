<?php

declare(strict_types=1);

namespace Project\Application\Application\Model\Command;

use Project\Application\Domain\ObjectValue\AggregateUuid;
use Shared\Application\Model\Command\CommandInterface;

final class ApplicationData implements CommandInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $aggregateUuid
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getAggregateUuid(): AggregateUuid
    {
        return AggregateUuid::fromString($this->aggregateUuid);
    }

    public function getLog(): string
    {
        return sprintf('Creating project application about name: %s', $this->name);
    }
}