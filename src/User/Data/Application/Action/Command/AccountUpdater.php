<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use Shared\Domain\Exception\NotFound;
use User\Data\Application\Model\Command\UpdateAccountModel;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class AccountUpdater
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateAccountModel $accountModel): void
    {
        $userData = $this->repository->findOneByUuid($accountModel->getUuid());

        if (!$userData) {
            throw new NotFound();
        }

        $this->repository->save(
            $userData->setProperties($accountModel->toArray())
        );
    }
}