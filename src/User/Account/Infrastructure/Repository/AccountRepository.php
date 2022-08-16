<?php

declare(strict_types=1);

namespace User\Account\Infrastructure\Repository;

use Shared\Infrastructure\Repository\AbstractRepository;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\Repository\AccountRepositoryInterface;

final class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
    public function findAllAccount(): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('a.uuid')
            ->addSelect('a.name')
            ->addSelect('a.surname')
            ->addSelect('a.is_active as status')
            ->from('account', 'a')
            ->fetchAllAssociative();
    }

    public function findAccountDataByUuid(AccountUuid $uuid): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('a.uuid')
            ->addSelect('a.name')
            ->addSelect('a.surname')
            ->addSelect('a.email')
            ->addSelect('a.is_active as status')
            ->from('account', 'a')
            ->where($qb->expr()->in('a.uuid', ':accountUuid'))
            ->setParameter('accountUuid', $uuid, 'uuid')
            ->fetchAssociative();
    }

    public function findOneByUuid(AccountUuid $uuid): ?Account
    {
        return $this->entityManager
            ->getRepository(Account::class)
            ->findOneBy(['uuid' => $uuid]);
    }

    public function findAllByUuids(AccountUuid ...$uuids): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb
            ->select('a')
            ->from(Account::class, 'a')
            ->where($qb->expr()->in('a.uuid', ':uuidArray'))
            ->setParameter('uuidArray', array_map(fn(AccountUuid $uuid): string => $uuid->toBinary(), $uuids)) //ToDo custom array type
            ->getQuery()
            ->execute();
    }
}