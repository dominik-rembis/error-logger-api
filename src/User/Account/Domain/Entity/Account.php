<?php

declare(strict_types=1);

namespace User\Account\Domain\Entity;

use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\ObjectValue\Role;
use User\Account\Infrastructure\Bridge\Security;

class Account extends Security
{
    public function __construct(
        protected AccountUuid $uuid,
        protected string $name,
        protected string $surname,
        protected string $email,
        protected string $password,
        protected Role $role,
        protected bool $isActive = true
    ) {}
}