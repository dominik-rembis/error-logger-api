<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Aggregate\Application\Model\Query\AggregateData;

final class ShowAggregateDada
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function __invoke(AggregateData $aggregateData): JsonResponse
    {
        return new JsonResponse(
            $this->queryBus->handle($aggregateData)
        );
    }
}