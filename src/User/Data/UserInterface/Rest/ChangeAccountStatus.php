<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Data\Application\Model\Command\AccountStatus;

final class ChangeAccountStatus
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(AccountStatus $accountStatus): JsonResponse
    {
        $this->commandBus->dispatch($accountStatus);

        return new JsonResponse();
    }
}