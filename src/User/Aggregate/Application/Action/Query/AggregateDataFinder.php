<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Aggregate\Application\Model\Query\AggregateData;
use User\Aggregate\Application\Dto\AggregateAccountRow;
use User\Aggregate\Application\Dto\AggregateDataRow;
use User\Aggregate\Domain\Repository\AggregateRepositoryInterface;

final class AggregateDataFinder
{
    public function __construct(
        private readonly AggregateRepositoryInterface $repository
    ) {}

    public function __invoke(AggregateData $aggregateData): AggregateDataRow
    {
        try {
            $aggregateData = $this->repository->findAggregateDataByUuid($aggregateData->getUuid());

            return new AggregateDataRow(
                reset($aggregateData)['name'],
                array_filter(
                    array_map(
                        fn(array $user): ?AggregateAccountRow => $user['uuid']
                            ? new AggregateAccountRow($user['uuid'], $user['firstname'], $user['surname'])
                            : null,
                        $aggregateData
                    )
                )
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}