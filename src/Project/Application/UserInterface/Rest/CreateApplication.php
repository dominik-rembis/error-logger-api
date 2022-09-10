<?php

declare(strict_types=1);

namespace Project\Application\UserInterface\Rest;

use Project\Application\Application\Model\Command\ApplicationData;
use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class CreateApplication
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(ApplicationData $applicationData): JsonResponse
    {
        $this->commandBus->dispatch($applicationData);

        return new JsonResponse(status: 201);
    }
}