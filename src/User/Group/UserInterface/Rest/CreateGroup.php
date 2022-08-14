<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Group\Application\Model\Command\GroupData;

final class CreateGroup
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(GroupData $groupData): JsonResponse
    {
        $this->commandBus->dispatch($groupData);

        return new JsonResponse(status: 201);
    }
}