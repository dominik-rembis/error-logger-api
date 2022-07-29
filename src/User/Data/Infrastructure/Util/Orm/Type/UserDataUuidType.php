<?php

declare(strict_types=1);

namespace User\Data\Infrastructure\Util\Orm\Type;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuidType;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class UserDataUuidType extends AbstractUuidType
{
    public function getName(): string
    {
        return 'user_data_uuid';
    }

    protected function getUidClass(): string
    {
        return UserDataUuid::class;
    }
}