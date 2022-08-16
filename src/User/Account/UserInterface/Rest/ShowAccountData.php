<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Account\Application\Model\Query\AccountData;

final class ShowAccountData
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function __invoke(AccountData $accountData): JsonResponse
    {
        return new JsonResponse(
            $this->queryBus->handle($accountData)
        );
    }
}