<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Aggregate\Application\Dto\AggregateSummaryRow;
use User\Aggregate\Application\Model\Query\AggregateList;
use User\Aggregate\Domain\Repository\AggregateRepositoryInterface;

final class AggregateListFinder
{
    public function __construct(
        private readonly AggregateRepositoryInterface $repository
    ) {}

    public function __invoke(AggregateList $aggregateList): array
    {
        try {
            return array_map(
                fn(array $summary): AggregateSummaryRow => new AggregateSummaryRow(...$summary),
                $this->repository->findAllAggregateSummary()
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}