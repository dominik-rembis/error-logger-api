<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Data\Application\Model\Query\AccountList;

final class ShowAccountList
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            $this->queryBus->handle(new AccountList())
        );
    }
}