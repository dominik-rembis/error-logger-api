<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Data\Application\Model\Command\NewAccountData;
use User\Data\Application\Model\Query\User;

final class AccountUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(NewAccountData $newAccountData): void
    {
        $userData = $this->queryBus->handle(new User((string) $newAccountData->getUuid()));

        $this->persistence->save(
            $userData->setProperties($newAccountData->toArray())
        );
    }
}