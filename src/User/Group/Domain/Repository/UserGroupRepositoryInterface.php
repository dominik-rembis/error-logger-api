<?php

namespace User\Group\Domain\Repository;

use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;

interface UserGroupRepositoryInterface
{
    public function findAllGroupSummary(): array;

    public function findGroupDataByUuid(UserGroupUuid $uuid): array;

    public function findOneByUuid(UserGroupUuid $uuid): ?UserGroup;
}