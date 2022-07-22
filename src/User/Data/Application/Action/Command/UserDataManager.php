<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use Shared\Application\Action\MessageHandlerInterface;
use User\Data\Application\Factory\UserDataFactory;
use User\Data\Application\Model\Command\UserDataModel;
use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Data\Domain\Service\HashGenerator;
use User\Data\Domain\Service\TokenGenerator;

final class UserDataManager implements MessageHandlerInterface
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(UserDataModel $userDataModel): void
    {
        $password = TokenGenerator::generate();

        $this->repository->save(
            UserDataFactory::create($userDataModel, HashGenerator::generate($password))
        );

        //ToDo implement sending the notification
    }
}