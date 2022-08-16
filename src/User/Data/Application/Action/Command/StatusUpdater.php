<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Data\Application\Model\Command\AccountStatus;
use User\Data\Application\Model\Query\User;

final class StatusUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(AccountStatus $accountStatus): void
    {
        $userData = $this->queryBus->handle(new User($accountStatus->getUuid()));

        $userData->setProperties($accountStatus->toArray());

        $this->persistence->save($userData);
    }
}