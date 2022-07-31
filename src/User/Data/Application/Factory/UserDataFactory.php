<?php

declare(strict_types=1);

namespace User\Data\Application\Factory;

use User\Data\Application\Model\Command\CreateAccountDataModel;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class UserDataFactory
{
    public static function create(CreateAccountDataModel $accountDataModel, string $password): UserData
    {
        return new UserData(
            UserDataUuid::generate(),
            $accountDataModel->getName(),
            $accountDataModel->getSurname(),
            $accountDataModel->getEmail(),
            $password
        );
    }
}