<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Query;

use Project\Application\Application\Model\Query\ApplicationEntity;
use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\Repository\ApplicationRepositoryInterface;
use Shared\Domain\Exception\NotFound;

final class ApplicationEntityFinder
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $repository
    ) {}

    public function __invoke(ApplicationEntity $application): Application
    {
        $applicationEntity = $this->repository->findOneByUuid($application->getUuid());

        return $applicationEntity ?? throw new NotFound();
    }
}