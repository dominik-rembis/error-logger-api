<?php

declare(strict_types=1);

namespace User\Group\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class UserGroupRepository implements UserGroupRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function save(UserGroup ...$userGroups): void
    {
        foreach ($userGroups as $userGroup) {
            $this->entityManager->persist($userGroup);
        }

        $this->entityManager->flush();
    }

    public function findOneByUuid(UserGroupUuid $uuid): UserGroup
    {
        return $this->entityManager
            ->getRepository(UserGroup::class)
            ->findOneBy(['uuid' => $uuid]);
    }
}