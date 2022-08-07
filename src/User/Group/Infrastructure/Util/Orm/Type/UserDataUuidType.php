<?php

declare(strict_types=1);

namespace User\Group\Infrastructure\Util\Orm\Type;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuidType;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class UserDataUuidType extends AbstractUuidType
{
    public function getName(): string
    {
        return 'user_group_uuid';
    }

    protected function getUidClass(): string
    {
        return UserGroupUuid::class;
    }
}