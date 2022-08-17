<?php

declare(strict_types=1);

namespace User\Aggregate\Domain\ObjectValue;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuid;

final class AggregateUuid extends AbstractUuid
{
    public function __construct(string $uuid)
    {
        $this->uid = $uuid;
    }
}