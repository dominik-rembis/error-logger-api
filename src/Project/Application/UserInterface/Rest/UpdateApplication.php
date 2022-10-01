<?php

declare(strict_types=1);

namespace Project\Application\UserInterface\Rest;

use Project\Application\Application\Model\Command\NewApplicationData;
use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class UpdateApplication
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(NewApplicationData $newApplicationData): JsonResponse
    {
        $this->commandBus->dispatch($newApplicationData);

        return new JsonResponse();
    }
}