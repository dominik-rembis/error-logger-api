<?php

declare(strict_types=1);

namespace User\Group\Application\Dto;

use User\Group\Domain\ObjectValue\UserGroupUuid;

final class GroupSummaryRow
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly int $userCount
    ) {}

    public function getUuid(): string
    {
        return UserGroupUuid::fromBinary($this->uuid)->toRfc4122();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserCount(): int
    {
        return $this->userCount;
    }
}