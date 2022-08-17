<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Aggregate\Application\Model\Command\AggregateData;

final class CreateAggregate
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(AggregateData $aggregateData): JsonResponse
    {
        $this->commandBus->dispatch($aggregateData);

        return new JsonResponse(status: 201);
    }
}