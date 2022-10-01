<?php

declare(strict_types=1);

namespace Project\Application\UserInterface\Rest;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Project\Application\Application\Model\Query\ApplicationList;

final class ShowApplicationList
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            $this->queryBus->handle(new ApplicationList())
        );
    }
}