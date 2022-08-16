<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Account\Application\Model\Query\Account;
use User\Account\Domain\Entity\Account as Entity;
use User\Account\Domain\Repository\AccountRepositoryInterface;

final class AccountFinder
{
    public function __construct(
        private readonly AccountRepositoryInterface $repository
    ) {}

    public function __invoke(Account $account): Entity
    {
        $accountData = $this->repository->findOneByUuid($account->getUuid());

        return $accountData ?? throw new NotFound();
    }
}