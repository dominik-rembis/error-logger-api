<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Command;

use Shared\Domain\Repository\PersistenceInterface;
use User\Account\Application\Factory\AccountFactory;
use User\Account\Application\Model\Command\AccountData;
use User\Account\Domain\Service\HashGenerator;
use User\Account\Domain\Service\TokenGenerator;

final class AccountCreator
{
    public function __construct(
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(AccountData $accountData): void
    {
        $password = HashGenerator::generate(TokenGenerator::generate(12));

        $this->persistence->save(
            AccountFactory::create($accountData, $password)
        );

        //ToDo implement sending the notification
    }
}