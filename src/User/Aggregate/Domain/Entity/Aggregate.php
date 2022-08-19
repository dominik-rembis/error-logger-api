<?php

declare(strict_types=1);

namespace User\Aggregate\Domain\Entity;

use Shared\Domain\Entity\AggregateRoot;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;
use User\Shared\Domain\Collection\AccountCollection;

class Aggregate extends AggregateRoot
{
    protected iterable $accounts;

    public function __construct(
        protected AggregateUuid $uuid,
        protected string $name,
        AccountCollection $accounts
    ) {
        $this->accounts = $accounts;
    }
}