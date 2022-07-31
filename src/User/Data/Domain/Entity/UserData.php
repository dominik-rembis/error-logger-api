<?php

declare(strict_types=1);

namespace User\Data\Domain\Entity;

use Shared\Domain\Entity\AggregateRoot;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class UserData extends AggregateRoot
{
    public function __construct(
        private UserDataUuid $uuid,
        private string $name,
        private string $surname,
        private string $email,
        private string $password
    ) {}
}