<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Aggregate\Application\Factory\AggregateFactory;
use User\Aggregate\Application\Model\Command\AggregateData;
use User\Shared\Application\Model\Query\AccountEntityCollection;

final class AggregateCreator
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(AggregateData $aggregateData): void
    {
        $accountCollection = $this->queryBus->handle(new AccountEntityCollection($aggregateData->getAccountUuids()));

        $this->persistence->save(
            AggregateFactory::create($aggregateData, $accountCollection)
        );
    }
}