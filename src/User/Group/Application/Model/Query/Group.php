<?php

declare(strict_types=1);

namespace User\Group\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;

final class Group implements QueryInterface
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
        return '';
    }
}