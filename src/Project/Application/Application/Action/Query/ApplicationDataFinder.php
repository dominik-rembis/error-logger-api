<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Query;

use Project\Application\Application\Dto\ApplicationDataRow;
use Project\Application\Application\Model\Query\ApplicationData;
use Project\Application\Domain\Repository\ApplicationRepositoryInterface;
use Shared\Domain\Exception\NotFound;

final class ApplicationDataFinder
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $repository
    ) {}

    public function __invoke(ApplicationData $applicationData): ApplicationDataRow
    {
        try {
            return new ApplicationDataRow(
                ...$this->repository->findDataByUuid($applicationData->getUuid())
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}