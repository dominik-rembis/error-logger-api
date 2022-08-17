<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Aggregate\Application\Model\Command\AggregateNewData;

final class UpdateAggregate
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(AggregateNewData $aggregateNewData): JsonResponse
    {
        $this->commandBus->dispatch($aggregateNewData);

        return new JsonResponse();
    }
}