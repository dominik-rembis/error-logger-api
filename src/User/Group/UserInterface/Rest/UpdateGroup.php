<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Group\Application\Model\Command\GroupNewData;

final class UpdateGroup
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(GroupNewData $groupNewData): JsonResponse
    {
        $this->commandBus->dispatch($groupNewData);

        return new JsonResponse();
    }
}