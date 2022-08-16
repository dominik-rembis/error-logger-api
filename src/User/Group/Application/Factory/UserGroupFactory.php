<?php

declare(strict_types=1);

namespace User\Group\Application\Factory;

use User\Group\Application\Model\Command\GroupData;
use User\Shared\Domain\Collection\AccountCollection;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class UserGroupFactory
{
    public static function create(GroupData $groupData, AccountCollection $accountCollection): UserGroup
    {
        return new UserGroup(
            UserGroupUuid::generate(),
            $groupData->getName(),
            $accountCollection
        );
    }
}