<?php

declare(strict_types=1);

namespace User\Aggregate\Infrastructure\Util\Orm\Type;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuidType;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;

final class AggregateUuidType extends AbstractUuidType
{
    public function getName(): string
    {
        return 'aggregate_uuid';
    }

    protected function getUidClass(): string
    {
        return AggregateUuid::class;
    }
}