<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Shared\Domain\Repository\SharedRepositoryInterface;

final class SharedRepository implements SharedRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function recordExist(string $entity, string $column, mixed $value): bool
    {
        $qb = $this->entityManager->createQueryBuilder();

        return (bool) $qb
            ->select('e.uuid')
            ->from($entity, 'e')
            ->where($qb->expr()->eq(sprintf('e.%s', $column), ':value'))
            ->setMaxResults(1)
            ->setParameter('value', $value)
            ->getQuery()
            ->execute();
    }
}