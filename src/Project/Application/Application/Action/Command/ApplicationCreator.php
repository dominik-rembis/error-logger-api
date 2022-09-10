<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Command;

use Project\Application\Application\Factory\ApplicationFactory;
use Project\Application\Application\Model\Command\ApplicationData;
use Shared\Domain\Repository\PersistenceInterface;

final class ApplicationCreator
{
    public function __construct(
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(ApplicationData $applicationData): void
    {
        $this->persistence->save(
            ApplicationFactory::create($applicationData)
        );
    }
}