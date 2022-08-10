<?php

declare(strict_types=1);

namespace User\Group\Infrastructure\Repository;

use Shared\Infrastructure\Repository\AbstractRepository;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class UserGroupRepository extends AbstractRepository implements UserGroupRepositoryInterface
{
    public function findOneByUuid(UserGroupUuid $uuid): ?UserGroup
    {
        return $this->entityManager
            ->getRepository(UserGroup::class)
            ->findOneBy(['uuid' => $uuid]);
    }
}