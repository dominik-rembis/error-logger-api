<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Shared\Domain\Entity\AggregateRoot;
use Shared\Domain\Repository\PersistenceInterface;

class PersistenceRepository implements PersistenceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function save(AggregateRoot ...$roots): void
    {
        foreach ($roots as $root) {
            $this->entityManager->persist($root);
        }

        $this->entityManager->flush();
    }
}