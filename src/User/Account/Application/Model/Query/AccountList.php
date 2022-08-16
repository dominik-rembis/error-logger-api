<?php

declare(strict_types=1);

namespace User\Account\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class AccountList implements QueryInterface
{
    public function getLog(): string
    {
        return 'Searching user account data list.';
    }
}