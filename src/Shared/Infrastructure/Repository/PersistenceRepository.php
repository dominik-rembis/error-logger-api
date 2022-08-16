<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Repository;

use Shared\Domain\Entity\AggregateRoot;
use Shared\Domain\Repository\PersistenceInterface;

class PersistenceRepository extends AbstractRepository implements PersistenceInterface
{
    public function save(AggregateRoot ...$roots): void
    {
        foreach ($roots as $root) {
            $this->entityManager->persist($root);
        }

        $this->entityManager->flush();
    }
}