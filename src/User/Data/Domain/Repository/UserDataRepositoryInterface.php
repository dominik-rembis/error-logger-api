<?php

declare(strict_types=1);

namespace User\Data\Domain\Repository;

use User\Data\Domain\Entity\UserData;

interface UserDataRepositoryInterface
{
    public function save(UserData ...$userData): void;
}