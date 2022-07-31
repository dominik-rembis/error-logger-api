<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Data\Application\Model\Command\UpdateAccountDataModel;

final class UpdateAccountData
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(UpdateAccountDataModel $accountDataModel): JsonResponse
    {
        $this->commandBus->dispatch($accountDataModel);

        return new JsonResponse();
    }
}