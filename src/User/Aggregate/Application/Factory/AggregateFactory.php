<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Factory;

use User\Aggregate\Application\Model\Command\AggregateData;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;
use User\Shared\Domain\Collection\AccountCollection;

final class AggregateFactory
{
    public static function create(AggregateData $aggregateData, AccountCollection $accountCollection): Aggregate
    {
        return new Aggregate(
            AggregateUuid::generate(),
            $aggregateData->getName(),
            $accountCollection
        );
    }
}