<?php

declare(strict_types=1);

namespace Project\Application\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class ApplicationList implements QueryInterface
{
    public function getLog(): string
    {
        return 'Searching project application data list.';
    }
}