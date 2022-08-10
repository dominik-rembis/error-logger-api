<?php

declare(strict_types=1);

namespace User\Data\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class User implements QueryInterface
{
    public function __construct(
        private readonly string $uuid
    ) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getLog(): string
    {
        return sprintf('Searching user with id: %s.', $this->uuid);
    }
}