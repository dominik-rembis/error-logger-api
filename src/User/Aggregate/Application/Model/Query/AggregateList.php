<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class AggregateList implements QueryInterface
{
    public function getLog(): string
    {
        return 'Searching user aggregate list.';
    }
}