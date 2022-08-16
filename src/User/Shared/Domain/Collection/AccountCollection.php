<?php

declare(strict_types=1);

namespace User\Shared\Domain\Collection;

use Shared\Infrastructure\Proxy\Collection\ArrayCollection;

final class AccountCollection extends ArrayCollection
{
    public function __construct(array $accounts)
    {
        parent::__construct($accounts);
    }
}