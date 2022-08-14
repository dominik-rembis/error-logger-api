<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use User\Group\Application\Model\Query\GroupData;

final class ShowGroupDada
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function __invoke(GroupData $groupData): JsonResponse
    {
        return new JsonResponse(
            $this->queryBus->handle($groupData)
        );
    }
}