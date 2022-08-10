<?php

declare(strict_types=1);

namespace Shared\Application\Action\Query;

use Shared\Application\Model\Query\QueryInterface;

interface QueryBusInterface
{
    public function handle(QueryInterface $query): mixed;
}