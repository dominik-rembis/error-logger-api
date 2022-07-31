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
            $this->entityManager->persist($data);
        }

        $this->entityManager->flush();
    }

    public function findOneByUuid(UserDataUuid $uuid): ?UserData
    {
        return $this->entityManager
            ->getRepository(UserData::class)
            ->findOneBy(['uuid' => $uuid]);
    }
}