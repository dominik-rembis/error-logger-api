<?php

declare(strict_types=1);

namespace User\Data\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
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
            $this->entityManager->merge($data);
        }

        $this->entityManager->flush();
    }

    public function findPasswordByUuid(UserDataUuid $uuid): string
    {
        return $this->entityManager->createQueryBuilder()
            ->select('ud.password')
            ->from(UserData::class, 'ud')
            ->where('ud.uuid = :uuid')
            ->setMaxResults(1)
            ->setParameter('uuid', $uuid, 'uuid')
            ->getQuery()
            ->getSingleScalarResult();
    }
}