<?php

declare(strict_types=1);

namespace User\Group\Infrastructure\Repository;

use Shared\Infrastructure\Repository\AbstractRepository;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class UserGroupRepository extends AbstractRepository implements UserGroupRepositoryInterface
{
    public function findAllGroupSummary(): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('ug.uuid')
            ->addSelect('ug.name')
            ->addSelect('COUNT(a.uuid) as userCount')
            ->from('user_group', 'ug')
            ->leftJoin('ug', 'user_group_aggregate', 'uga', 'ug.uuid = uga.user_group_uuid')
            ->leftJoin('uga', 'account', 'a', 'uga.account_uuid = a.uuid AND a.is_active = 1')
            ->groupBy('ug.uuid')
            ->orderBy('ug.name', 'ASC')
            ->fetchAllAssociative();
    }

    public function findGroupDataByUuid(UserGroupUuid $uuid): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('ug.name')
            ->addSelect('a.uuid')
            ->addSelect('a.name as firstname')
            ->addSelect('a.surname')
            ->from('user_group', 'ug')
            ->leftJoin('ug', 'user_group_aggregate', 'uga', 'ug.uuid = uga.user_group_uuid')
            ->leftJoin('uga', 'account', 'a', 'uga.account_uuid = a.uuid AND a.is_active = 1')
            ->where($qb->expr()->eq('ug.uuid', ':groupUuid'))
            ->setParameter('groupUuid', $uuid, 'uuid')
            ->fetchAllAssociative();
    }

    public function findOneByUuid(UserGroupUuid $uuid): ?UserGroup
    {
        return $this->entityManager
            ->getRepository(UserGroup::class)
            ->findOneBy(['uuid' => $uuid]);
    }
}