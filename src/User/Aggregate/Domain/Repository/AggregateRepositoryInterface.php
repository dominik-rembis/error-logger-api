<?php

namespace User\Aggregate\Domain\Repository;

use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;

interface AggregateRepositoryInterface
{
    public function findAllAggregateSummary(): array;

    public function findAggregateDataByUuid(AggregateUuid $uuid): array;

    public function findOneByUuid(AggregateUuid $uuid): ?Aggregate;
}