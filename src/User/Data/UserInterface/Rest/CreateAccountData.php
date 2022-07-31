<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Data\Application\Model\Command\CreateAccountDataModel;

final class CreateAccountData
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(CreateAccountDataModel $accountDataModel): JsonResponse
    {
        $this->commandBus->dispatch($accountDataModel);

        return new JsonResponse(status: 201);
    }
}