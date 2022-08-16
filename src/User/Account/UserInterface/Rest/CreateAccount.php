<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Account\Application\Model\Command\AccountData;

final class CreateAccount
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(AccountData $accountData): JsonResponse
    {
        $this->commandBus->dispatch($accountData);

        return new JsonResponse(status: 201);
    }
}