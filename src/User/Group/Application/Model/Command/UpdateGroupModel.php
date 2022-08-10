<?php

declare(strict_types=1);

namespace User\Group\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;

final class UpdateGroupModel implements CommandInterface
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly array $userUuids = []
    ) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserUuids(): array
    {
        return $this->userUuids;
    }

    public function getLog(): string
    {
        return sprintf('Updating group with uuid: %s', $this->uuid);
    }
}