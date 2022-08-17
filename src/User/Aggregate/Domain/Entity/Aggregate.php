<?php

declare(strict_types=1);

namespace User\Aggregate\Domain\Entity;

use Shared\Domain\Entity\AggregateRoot;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;
use User\Shared\Domain\Collection\AccountCollection;

final class Aggregate extends AggregateRoot
{
    private iterable $accounts;

    public function __construct(
        private AggregateUuid $uuid,
        private string $name,
        AccountCollection $accounts
    ) {
        $this->accounts = $accounts;
    }
}