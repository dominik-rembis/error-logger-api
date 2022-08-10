<?php

declare(strict_types=1);

namespace Shared\Domain\Repository;

use Shared\Domain\Entity\AggregateRoot;

interface PersistenceInterface
{
    public function save(AggregateRoot ...$roots): void;
}