<?php

declare(strict_types=1);

namespace User\Data\Domain\Repository;

use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

interface UserDataRepositoryInterface
{
    public function save(UserData ...$userData): void;

    public function findPasswordByUuid(UserDataUuid $uuid): string;
}