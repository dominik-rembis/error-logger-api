<?php

declare(strict_types=1);

namespace Project\Application\Infrastructure\Fixture;

use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\ObjectValue\AggregateUuid;
use Project\Application\Domain\ObjectValue\ApplicationUuid;
use Shared\Infrastructure\Adapter\Fixture\AbstractFixture;

class ApplicationData extends AbstractFixture
{
    public function execute(array $context): void
    {
        $this->save(
            new Application(
                ApplicationUuid::fromString($context['applicationUuid']),
                $context['name'] ?? 'exampleName',
                isset($context['aggregateUuid'])
                    ? AggregateUuid::fromString($context['aggregateUuid'])
                    : AggregateUuid::generate()
            )
        );
    }
}