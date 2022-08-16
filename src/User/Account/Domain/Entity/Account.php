<?php

declare(strict_types=1);

namespace User\Account\Domain\Entity;

use Shared\Domain\Entity\AggregateRoot;
use User\Account\Domain\ObjectValue\AccountUuid;

final class Account extends AggregateRoot
{
    public function __construct(
        private AccountUuid $uuid,
        private string $name,
        private string $surname,
        private string $email,
        private string $password,
        private bool $isActive = true
    ) {}
}