<?php

declare(strict_types=1);

namespace Project\Application\Domain\Entity;

use Project\Application\Domain\ObjectValue\AggregateUuid;
use Project\Application\Domain\ObjectValue\ApplicationUuid;
use Shared\Domain\Entity\AggregateRoot;

class Application extends AggregateRoot
{
    public function __construct(
        protected ApplicationUuid $uuid,
        protected string $name,
        protected AggregateUuid $aggregateUuid
    ) {}
}