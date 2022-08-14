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
            ->addSelect('COUNT(ud.name) as userCount')
            ->from('user_group', 'ug')
            ->leftJoin('ug', 'user_group_aggregate', 'uga', 'ug.uuid = uga.user_group_uuid')
            ->leftJoin('uga', 'user_data', 'ud', 'uga.user_data_uuid = ud.uuid')
            ->groupBy('ug.uuid')
            ->orderBy('ug.name', 'ASC')
            ->fetchAllAssociative();
    }

    public function findGroupDataByUuid(UserGroupUuid $uuid): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('ug.name')
            ->addSelect('ud.uuid')
            ->addSelect('ud.name as firstname')
            ->addSelect('ud.surname')
            ->from('user_group', 'ug')
            ->leftJoin('ug', 'user_group_aggregate', 'uga', 'ug.uuid = uga.user_group_uuid')
            ->leftJoin('uga', 'user_data', 'ud', 'uga.user_data_uuid = ud.uuid')
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