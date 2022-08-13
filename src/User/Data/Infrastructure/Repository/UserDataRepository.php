<?php

declare(strict_types=1);

namespace User\Data\Infrastructure\Repository;

use Shared\Infrastructure\Repository\AbstractRepository;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class UserDataRepository extends AbstractRepository implements UserDataRepositoryInterface
{
    public function findAllAccount(): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('ud.uuid')
            ->addSelect('ud.name')
            ->addSelect('ud.surname')
            ->from('user_data', 'ud')
            ->fetchAllAssociative();
    }

    public function findAccountDataByUuid(UserDataUuid $uuid): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('ud.uuid')
            ->addSelect('ud.name')
            ->addSelect('ud.surname')
            ->addSelect('ud.email')
            ->from('user_data', 'ud')
            ->where($qb->expr()->in('ud.uuid', ':userUuid'))
            ->setParameter('userUuid', $uuid, 'uuid')
            ->fetchAssociative();
    }

    public function findOneByUuid(UserDataUuid $uuid): ?UserData
    {
        return $this->entityManager
            ->getRepository(UserData::class)
            ->findOneBy(['uuid' => $uuid]);
    }

    public function findAllByUuids(UserDataUuid ...$uuids): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb
            ->select('ud')
            ->from(UserData::class, 'ud')
            ->where($qb->expr()->in('ud.uuid', ':uuidArray'))
            ->setParameter('uuidArray', array_map(fn(UserDataUuid $uuid): string => $uuid->toBinary(), $uuids)) //ToDo custom array type
            ->getQuery()
            ->execute();
    }
}