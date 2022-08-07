<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Data\Application\Model\Command\UpdateAccountModel;

final class UpdateAccount
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(UpdateAccountModel $accountModel): JsonResponse
    {
        $this->commandBus->dispatch($accountModel);

        return new JsonResponse();
    }
}