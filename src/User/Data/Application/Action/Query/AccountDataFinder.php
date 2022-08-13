<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Data\Application\Dto\AccountDataRow;
use User\Data\Application\Model\Query\AccountData;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class AccountDataFinder
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
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