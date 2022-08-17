<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Aggregate\Application\Model\Query\AggregateEntity;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Domain\Repository\AggregateRepositoryInterface;

final class AggregateEntityFinder
{
    public function __construct(
        private readonly AggregateRepositoryInterface $repository
    ) {}

    public function __invoke(AggregateEntity $aggregateEntity): Aggregate
    {
        $aggregate = $this->repository->findOneByUuid($aggregateEntity->getUuid());

        return $aggregate ?? throw new NotFound();
    }
}