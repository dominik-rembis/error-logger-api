<?php

declare(strict_types=1);

namespace User\Group\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class UpdateGroupModel implements CommandInterface
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly array $userUuids = []
    ) {}

    public function getUuid(): UserGroupUuid
    {
        return UserGroupUuid::fromString($this->uuid);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserUuids(): array
    {
        return array_map(
            fn(string $uuid): UserDataUuid => UserDataUuid::fromString($uuid),
            $this->userUuids
        );
    }

    public function getLog(): string
    {
        return sprintf('Updating group with uuid: %s', $this->uuid);
    }
}