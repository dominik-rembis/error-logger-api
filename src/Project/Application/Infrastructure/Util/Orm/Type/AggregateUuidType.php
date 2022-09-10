<?php

declare(strict_types=1);

namespace Project\Application\Infrastructure\Util\Orm\Type;

use Project\Application\Domain\ObjectValue\AggregateUuid;
use Shared\Infrastructure\Adapter\Uuid\AbstractUuidType;

final class AggregateUuidType extends AbstractUuidType
{
    public function getName(): string
    {
        return 'aggregate_identifier';
    }

    protected function getUidClass(): string
    {
        return AggregateUuid::class;
    }
}