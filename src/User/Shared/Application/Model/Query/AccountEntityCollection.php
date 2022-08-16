<?php

declare(strict_types=1);

namespace User\Shared\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class AccountEntityCollection implements QueryInterface
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
        return sprintf('Searching users entity collection with uuids: %s.', implode(', ', $this->uuids));
    }
}