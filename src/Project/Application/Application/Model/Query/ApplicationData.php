<?php

declare(strict_types=1);

namespace Project\Application\Application\Model\Query;

use Project\Application\Domain\ObjectValue\ApplicationUuid;
use Shared\Application\Model\Query\QueryInterface;

final class ApplicationData implements QueryInterface
{
    public function __construct(
        private readonly string $uuid
    ) {}

    public function getUuid(): ApplicationUuid
    {
        return ApplicationUuid::fromString($this->uuid);
    }

    public function getLog(): string
    {
        return 'Searching project application data';
    }
}