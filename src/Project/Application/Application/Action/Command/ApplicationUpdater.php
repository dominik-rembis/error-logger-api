<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Command;

use Project\Application\Application\Model\Command\NewApplicationData;
use Project\Application\Application\Model\Query\ApplicationEntity;
use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;

final class ApplicationUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(NewApplicationData $newApplicationData): void
    {
        $applicationData = $this->queryBus->handle(new ApplicationEntity($newApplicationData->getUuid()));

        $this->persistence->save(
            $applicationData->setProperties(
                $newApplicationData->toArray()
            )
        );
    }
}