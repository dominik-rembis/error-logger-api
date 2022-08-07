<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use User\Data\Application\Factory\UserDataFactory;
use User\Data\Application\Model\Command\CreateAccountModel;
use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Data\Domain\Service\HashGenerator;
use User\Data\Domain\Service\TokenGenerator;

final class AccountCreator
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(CreateAccountModel $accountModel): void
    {
        $password = HashGenerator::generate(TokenGenerator::generate(12));

        $this->repository->save(
            UserDataFactory::create($accountModel, $password)
        );

        //ToDo implement sending the notification
    }
}