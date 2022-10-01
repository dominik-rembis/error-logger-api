<?php

declare(strict_types=1);

namespace Project\Application\Infrastructure\Repository;

use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\ObjectValue\ApplicationUuid;
use Project\Application\Domain\Repository\ApplicationRepositoryInterface;
use Shared\Infrastructure\Repository\AbstractRepository;

class ApplicationRepository extends AbstractRepository implements ApplicationRepositoryInterface
{
    public function findOneByUuid(ApplicationUuid $uuid): ?Application
    {
        return $this->entityManager
            ->getRepository(Application::class)
            ->findOneBy(['uuid' => $uuid]);
    }

    public function findAllApplication(): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('a.uuid')
            ->addSelect('a.name')
            ->from('application', 'a')
            ->fetchAllAssociative();
    }

    public function findDataByUuid(ApplicationUuid $uuid): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('a.uuid')
            ->addSelect('a.name')
            ->addSelect('a.aggregate_uuid as aggregateUuid')
            ->from('application', 'a')
            ->where($qb->expr()->in('a.uuid', ':applicationUuid'))
            ->setParameter('applicationUuid', $uuid, 'uuid')
            ->fetchAssociative();
    }
}