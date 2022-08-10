<?php

declare(strict_types=1);

namespace User\Shared\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class UserCollection implements QueryInterface
{
    public function __construct(
        private readonly array $uuids
    ) {}

    public function getUuids(): array
    {
        return $this->uuids;
    }

    public function getLog(): string
    {
        return sprintf('Searching users collection with ids: %s.', implode(', ', $this->uuids));
    }
}