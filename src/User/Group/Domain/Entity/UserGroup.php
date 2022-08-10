<?php

declare(strict_types=1);

namespace User\Group\Domain\Entity;

use Shared\Domain\Entity\AggregateRoot;
use User\Shared\Domain\Collection\UserDataCollection;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class UserGroup extends AggregateRoot
{
    private iterable $users;

    public function __construct(
        private UserGroupUuid $uuid,
        private string $name,
        UserDataCollection $users
    ) {
        $this->users = $users;
    }
}