<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Data\Application\Model\Query\User;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class UserFinder
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(User $user): UserData
    {
        $userData = $this->repository->findOneByUuid($user->getUuid());

        return $userData ?? throw new NotFound();
    }
}