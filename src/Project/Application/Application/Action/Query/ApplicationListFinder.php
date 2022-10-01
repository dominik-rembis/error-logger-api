<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Query;

use Project\Application\Application\Dto\ApplicationDataRow;
use Project\Application\Application\Model\Query\ApplicationList;
use Project\Application\Domain\Repository\ApplicationRepositoryInterface;
use Shared\Domain\Exception\NotFound;

final class ApplicationListFinder
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $repository
    ) {}

    public function __invoke(ApplicationList $applicationList): array
    {
        try {
            return array_map(
                fn(array $application): ApplicationDataRow => new ApplicationDataRow(...$application),
                $this->repository->findAllApplication()
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}