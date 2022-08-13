<?php

namespace Shared\Application\Action\Query;

use Shared\Application\Model\Query\ExampleQueryMockImplementingQueryInterface;

final class ExampleQueryHandler
{
    public function __invoke(ExampleQueryMockImplementingQueryInterface $query): void
    {
        throw new \DomainException('Domain exception confirming correct connection');
    }
}