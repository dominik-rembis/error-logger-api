<?php

declare(strict_types=1);

namespace Shared\Domain\Repository;

interface SharedRepositoryInterface
{
    public function recordExist(
        string $entity,
        string $column,
        mixed $value,
        ?string $excludeByColumn = null,
        mixed $excludedValue = null
    ): bool;
}