<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Group\Application\Model\Query\GroupList;

final class ShowGroupList
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            $this->queryBus->handle(new GroupList())
        );
    }
}