<?php

declare(strict_types=1);

namespace Project\Application\Infrastructure\Util\Orm\Type;

use Project\Application\Domain\ObjectValue\ApplicationUuid;
use Shared\Infrastructure\Adapter\Uuid\AbstractUuidType;

final class ApplicationUuidType extends AbstractUuidType
{
    public function getName(): string
    {
        return 'application_uuid';
    }

    protected function getUidClass(): string
    {
        return ApplicationUuid::class;
    }
}