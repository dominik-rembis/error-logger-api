<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;

final class AggregateData implements QueryInterface
{
    public function __construct(
        private readonly string $uuid
    ) {}

    public function getUuid(): AggregateUuid
    {
        return AggregateUuid::fromString($this->uuid);
    }

    public function getLog(): string
    {
        return sprintf('Searching aggregate data by uuid: %s', $this->uuid);
    }
}