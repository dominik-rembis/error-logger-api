<?php

declare(strict_types=1);

namespace User\Account\Application\Factory;

use User\Account\Application\Model\Command\AccountData;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\ObjectValue\Role;

final class AccountFactory
{
    public static function create(AccountData $accountData, string $password): Account
    {
        return new Account(
            AccountUuid::generate(),
            $accountData->getName(),
            $accountData->getSurname(),
            $accountData->getEmail(),
            $password,
            $accountData->getRole()
        );
    }
}