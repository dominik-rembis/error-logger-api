<?php

declare(strict_types=1);

namespace User\Group\Application\Dto;

final class GroupDataRow
{
    public function __construct(
        private readonly string $name,
        private readonly array $users
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsers(): array
    {
        return $this->users;
    }
}