<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Data\Application\Model\Command\CreateAccountModel;

final class CreateAccount
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(CreateAccountModel $accountModel): JsonResponse
    {
        $this->commandBus->dispatch($accountModel);

        return new JsonResponse(status: 201);
    }
}