<?php

declare(strict_types=1);

namespace User\Data\Domain\Repository;

use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

interface UserDataRepositoryInterface
{
    public function findAllAccount(): array;

    public function findAccountDataByUuid(UserDataUuid $uuid): array;

    public function findOneByUuid(UserDataUuid $uuid): ?UserData;

    /** @return UserData[] */
    public function findAllByUuids(UserDataUuid ...$uuids): array;
}