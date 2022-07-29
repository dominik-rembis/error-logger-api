<?php

declare(strict_types=1);

namespace User\Data\Application\Factory;

use User\Data\Application\Model\Command\UserDataModel;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class UserDataFactory
{
    public static function create(UserDataModel $userDataModel, string $password): UserData
    {
        return new UserData(
            $userDataModel->getUuid() ?? UserDataUuid::generate(),
            $userDataModel->getName(),
            $userDataModel->getSurname(),
            $userDataModel->getEmail(),
            $password
        );
    }
}