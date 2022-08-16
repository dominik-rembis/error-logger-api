<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Account\Application\Dto\AccountDataRow;
use User\Account\Application\Model\Query\AccountData;
use User\Account\Domain\Repository\AccountRepositoryInterface;

final class AccountDataFinder
{
    public function __construct(
        private readonly AccountRepositoryInterface $repository
    ) {}

    public function __invoke(AccountData $accountData): AccountDataRow
    {
        try {
            return new AccountDataRow(
                ...$this->repository->findAccountDataByUuid($accountData->getUuid())
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}