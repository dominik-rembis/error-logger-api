<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use User\Data\Application\Factory\UserDataFactory;
use User\Data\Application\Model\Command\UserDataModel;
use User\Data\Application\Policy\PasswordPolicy;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class UserDataManager
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(UserDataModel $userDataModel): void
    {
        $password = PasswordPolicy::apply($userDataModel->getUuid(), $this->repository)->getPassword();

        $this->repository->save(
            UserDataFactory::create($userDataModel, $password)
        );

        //ToDo implement sending the notification
    }
}