<?php

declare(strict_types=1);

namespace User\Group\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class GroupList implements QueryInterface
{
    public function getLog(): string
    {
        return 'Searching user group list.';
    }
}