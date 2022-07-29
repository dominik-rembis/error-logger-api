<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Data\Application\Model\Command\UserDataModel;

final class UpdateAccountData
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(UserDataModel $userDataModel): JsonResponse
    {
        $this->commandBus->dispatch($userDataModel);

        return new JsonResponse();
    }
}