<?php

declare(strict_types=1);

namespace User\Group\Application\Factory;

use User\Data\Domain\Collection\UserDataCollection;
use User\Group\Application\Model\Command\CreateGroupModel;
use User\Group\Application\Model\Command\UpdateGroupModel;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class UserGroupFactory
{
    public static function create(CreateGroupModel $groupModel, array $users): UserGroup
    {
        return new UserGroup(
            UserGroupUuid::generate(),
            $groupModel->getName(),
            new UserDataCollection(...$users)
        );
    }

    public static function createPropertiesArray(UpdateGroupModel $groupModel, array $users): array
    {
        return [
            'name' => $groupModel->getName(),
            'users' => new UserDataCollection(...$users)
        ];
    }
}