<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Data\Application\Dto\AccountDataRow;
use User\Data\Application\Model\Query\AccountList;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class AccountListFinder
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
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