<?php

declare(strict_types=1);

namespace User\Group\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Shared\Domain\Entity\AggregateRoot;
use User\Group\Domain\ObjectValue\UserGroupUuid;

final class UserGroup extends AggregateRoot
{
    public function __construct(
        private UserGroupUuid $uuid,
        private string $name,
        private Collection $users
    ) {}
}