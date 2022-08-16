<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Account\Application\Model\Command\NewAccountData;

final class UpdateAccount
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(NewAccountData $newAccountData): JsonResponse
    {
        $this->commandBus->dispatch($newAccountData);

        return new JsonResponse();
    }
}