<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\MessageBus;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Application\Model\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class QueryBus implements QueryBusInterface
{
    use HandleTrait { handle as handleQuery; }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function handle(QueryInterface $query): mixed
    {
        return $this->handleQuery($query);
    }
}