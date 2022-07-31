<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use User\Data\Application\Factory\UserDataFactory;
use User\Data\Application\Model\Command\CreateAccountDataModel;
use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Data\Domain\Service\HashGenerator;
use User\Data\Domain\Service\TokenGenerator;

final class AccountDataCreator
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(CreateAccountDataModel $accountDataModel): void
    {
        $password = HashGenerator::generate(TokenGenerator::generate(12));

        $this->repository->save(
            UserDataFactory::create($accountDataModel, $password)
        );

        //ToDo implement sending the notification
    }
}