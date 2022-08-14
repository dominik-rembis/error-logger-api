<?php

declare(strict_types=1);

namespace User\Group\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class GroupData implements QueryInterface
{
    public function __construct(
        private readonly string $uuid
    ) {}

    public function getUuid(): UserGroupUuid
    {
        return UserGroupUuid::fromString($this->uuid);
    }

    public function getLog(): string
    {
        return sprintf('Searching group data by uuid: %s', $this->uuid);
    }
}