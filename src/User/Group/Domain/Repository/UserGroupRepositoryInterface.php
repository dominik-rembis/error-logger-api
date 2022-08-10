<?php

namespace User\Group\Domain\Repository;

use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;

interface UserGroupRepositoryInterface
{
    public function findOneByUuid(UserGroupUuid $uuid): ?UserGroup;
}