<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Account\Application\Model\Command\AccountStatus;
use User\Account\Application\Model\Query\AccountEntity;

final class StatusUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(AccountStatus $accountStatus): void
    {
        $userData = $this->queryBus->handle(new AccountEntity($accountStatus->getUuid()));

        $userData->setProperties($accountStatus->toArray());

        $this->persistence->save($userData);
    }
}