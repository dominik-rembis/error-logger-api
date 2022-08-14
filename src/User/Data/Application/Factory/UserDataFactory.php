<?php

declare(strict_types=1);

namespace User\Data\Application\Factory;

use User\Data\Application\Model\Command\AccountData;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class UserDataFactory
{
    public static function create(AccountData $accountData, string $password): UserData
    {
        return new UserData(
            UserDataUuid::generate(),
            $accountData->getName(),
            $accountData->getSurname(),
            $accountData->getEmail(),
            $password
        );
    }
}