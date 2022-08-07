<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Group\Application\Model\Command\CreateGroupModel;

final class CreateGroup
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(CreateGroupModel $groupModel): JsonResponse
    {
        $this->commandBus->dispatch($groupModel);

        return new JsonResponse(status: 201);
    }
}