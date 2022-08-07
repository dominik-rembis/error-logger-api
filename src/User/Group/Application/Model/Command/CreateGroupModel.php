<?php

declare(strict_types=1);

namespace User\Group\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class CreateGroupModel implements CommandInterface
{
    public function __construct(
        private readonly string $name,
        private readonly array $userUuids = []
    ) {}

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
        return 'Creating a new user group';
    }
}