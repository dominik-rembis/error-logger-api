<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use Shared\Domain\Repository\PersistenceInterface;
use User\Data\Application\Factory\UserDataFactory;
use User\Data\Application\Model\Command\AccountData;
use User\Data\Domain\Service\HashGenerator;
use User\Data\Domain\Service\TokenGenerator;

final class AccountCreator
{
    public function __construct(
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(AccountData $accountData): void
    {
        $password = HashGenerator::generate(TokenGenerator::generate(12));

        $this->persistence->save(
            UserDataFactory::create($accountData, $password)
        );

        //ToDo implement sending the notification
    }
}