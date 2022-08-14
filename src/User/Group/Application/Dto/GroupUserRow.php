<?php

declare(strict_types=1);

namespace User\Group\Application\Dto;

use User\Group\Domain\ObjectValue\UserGroupUuid;

final class GroupUserRow
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $surname,
    ) {}

    public function getUuid(): string
    {
        return UserGroupUuid::fromBinary($this->uuid)->toRfc4122();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }
}