<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Account\Application\Model\Query\AccountEntity;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\Repository\AccountRepositoryInterface;

final class AccountEntityFinder
{
    public function __construct(
        private readonly AccountRepositoryInterface $repository
    ) {}

    public function __invoke(AccountEntity $account): Account
    {
        $accountEntity = $this->repository->findOneByUuid($account->getUuid());

        return $accountEntity ?? throw new NotFound();
    }
}