<?php

declare(strict_types=1);

namespace User\Data\Application\Factory;

use User\Data\Application\Model\Command\CreateAccountModel;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class UserDataFactory
{
    public static function create(CreateAccountModel $accountModel, string $password): UserData
    {
        return new UserData(
            UserDataUuid::generate(),
            $accountModel->getName(),
            $accountModel->getSurname(),
            $accountModel->getEmail(),
            $password
        );
    }
}