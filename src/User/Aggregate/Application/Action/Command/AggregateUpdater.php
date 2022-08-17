<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Aggregate\Application\Model\Command\AggregateNewData;
use User\Aggregate\Application\Model\Query\AggregateEntity;
use User\Shared\Application\Model\Query\AccountEntityCollection;

final class AggregateUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(AggregateNewData $groupNewData): void
    {
        $group = $this->queryBus->handle(new AggregateEntity($groupNewData->getUuid()));
        $accounts = $this->queryBus->handle(new AccountEntityCollection($groupNewData->getAccountUuids()));

        $group->setProperties([
            'name' => $groupNewData->getName(),
            'accounts' => $accounts
        ]);

        $this->persistence->save($group);
    }
}