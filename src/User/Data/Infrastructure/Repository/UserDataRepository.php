<?php

declare(strict_types=1);

namespace User\Data\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class UserDataRepository implements UserDataRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function save(UserData ...$userData): void
    {
        foreach ($userData as $data) {
            $this->entityManager->persist($data);
        }

        $this->entityManager->flush();
    }

    public function findOneByUuid(UserDataUuid $uuid): ?UserData
    {
        return $this->getRepository()
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

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(UserData::class);
    }
}