<?php

declare(strict_types=1);

namespace User\Group\Application\Factory;

use User\Shared\Domain\Collection\UserDataCollection;
use User\Group\Application\Model\Command\CreateGroupModel;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class UserGroupFactory
{
    public static function create(CreateGroupModel $groupModel, UserDataCollection $users): UserGroup
    {
        return new UserGroup(
            UserGroupUuid::generate(),
            $groupModel->getName(),
            $users
        );
    }
}