<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Fixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractFixture extends Fixture
{
    private ObjectManager $objectManager;

    public function __construct(
        private readonly array $context
    ) {}

    abstract public function execute(array $context): void;

    public function load(ObjectManager $manager): void
    {
        $this->objectManager = $manager;
        $this->execute($this->context);
    }

    protected function save(object ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->objectManager->persist($entity);
        }

        $this->objectManager->flush();
    }
}