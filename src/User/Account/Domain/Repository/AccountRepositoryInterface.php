<?php

declare(strict_types=1);

namespace User\Account\Domain\Repository;

use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;

interface AccountRepositoryInterface
{
    public function findAllAccount(): array;

    public function findAccountDataByUuid(AccountUuid $uuid): array;

    public function findOneByUuid(AccountUuid $uuid): ?Account;

    /** @return Account[] */
    public function findAllByUuids(AccountUuid ...$uuids): array;
}