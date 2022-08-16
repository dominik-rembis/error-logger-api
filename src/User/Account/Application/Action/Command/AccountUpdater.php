<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Account\Application\Model\Command\NewAccountData;
use User\Account\Application\Model\Query\Account;

final class AccountUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(NewAccountData $newAccountData): void
    {
        $userData = $this->queryBus->handle(new Account((string) $newAccountData->getUuid()));

        $this->persistence->save(
            $userData->setProperties($newAccountData->toArray())
        );
    }
}