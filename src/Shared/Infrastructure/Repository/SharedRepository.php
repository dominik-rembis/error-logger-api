<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Repository;

use Shared\Domain\Repository\SharedRepositoryInterface;

final class SharedRepository extends AbstractRepository implements SharedRepositoryInterface
{
    public function recordExist(
        string $entity,
        string $column,
        mixed $value,
        ?string $excludeByColumn = null,
        mixed $excludedValue = null
    ): bool
    {
        $qb = $this->entityManager->createQueryBuilder();

        $query = $qb
            ->select('e.uuid')
            ->from($entity, 'e')
            ->where($qb->expr()->eq(sprintf('e.%s', $column), ':value'))
            ->setParameter('value', $value);

        if ($excludeByColumn && $excludedValue) {
            $query
                ->andWhere($qb->expr()->neq(sprintf('e.%s', $excludeByColumn), ':excludedValue'))
                ->setParameter('excludedValue', $excludedValue, self::prepareType($excludedValue));
        }

        return (bool) $query
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
    }

    private static function prepareType(mixed $value): ?string
    {
        return uuid_is_valid((string) $value) ? 'uuid' : null;
    }
}