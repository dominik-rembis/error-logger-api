<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Account\Application\Dto\AccountDataRow;
use User\Account\Application\Model\Query\AccountList;
use User\Account\Domain\Repository\AccountRepositoryInterface;

final class AccountListFinder
{
    public function __construct(
        private readonly AccountRepositoryInterface $repository
    ) {}

    public function __invoke(AccountList $accountList): array
    {
        try {
            return array_map(
                fn(array $account): AccountDataRow => new AccountDataRow(...$account),
                $this->repository->findAllAccount()
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}