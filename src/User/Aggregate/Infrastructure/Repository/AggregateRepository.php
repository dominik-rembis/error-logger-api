<?php

declare(strict_types=1);

namespace User\Aggregate\Infrastructure\Repository;

use Shared\Infrastructure\Repository\AbstractRepository;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;
use User\Aggregate\Domain\Repository\AggregateRepositoryInterface;

final class AggregateRepository extends AbstractRepository implements AggregateRepositoryInterface
{
    public function findAllAggregateSummary(): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('ag.uuid')
            ->addSelect('ag.name')
            ->addSelect('COUNT(ac.uuid) as accountCount')
            ->from('aggregate', 'ag')
            ->leftJoin('ag', 'account_aggregate', 'aa', 'ag.uuid = aa.aggregate_uuid')
            ->leftJoin('aa', 'account', 'ac', 'aa.account_uuid = ac.uuid AND ac.is_active = 1')
            ->groupBy('ag.uuid')
            ->orderBy('ag.name', 'ASC')
            ->fetchAllAssociative();
    }

    public function findAggregateDataByUuid(AggregateUuid $uuid): array
    {
        $qb = $this->entityManager->getConnection()->createQueryBuilder();

        return $qb
            ->select('ag.name')
            ->addSelect('ac.uuid')
            ->addSelect('ac.name as firstname')
            ->addSelect('ac.surname')
            ->from('aggregate', 'ag')
            ->leftJoin('ag', 'account_aggregate', 'aa', 'ag.uuid = aa.aggregate_uuid')
            ->leftJoin('aa', 'account', 'ac', 'aa.account_uuid = ac.uuid AND ac.is_active = 1')
            ->where($qb->expr()->eq('ag.uuid', ':groupUuid'))
            ->setParameter('groupUuid', $uuid, 'uuid')
            ->fetchAllAssociative();
    }

    public function findOneByUuid(AggregateUuid $uuid): ?Aggregate
    {
        return $this->entityManager
            ->getRepository(Aggregate::class)
            ->findOneBy(['uuid' => $uuid]);
    }
}