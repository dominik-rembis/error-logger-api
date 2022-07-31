<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use Shared\Domain\Exception\NotFound;
use User\Data\Application\Model\Command\UpdateAccountDataModel;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

class AccountDataUpdater
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateAccountDataModel $accountDataModel): void
    {
        $userData = $this->repository->findOneByUuid($accountDataModel->getUuid());

        if (!$userData) {
            throw new NotFound();
        }

        $this->repository->save(
            $userData->setProperties($accountDataModel->toArray())
        );
    }
}