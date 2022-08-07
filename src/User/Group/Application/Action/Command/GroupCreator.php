<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Group\Application\Factory\UserGroupFactory;
use User\Group\Application\Model\Command\CreateGroupModel;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class GroupCreator
{
    public function __construct(
        private readonly UserDataRepositoryInterface $userDataRepository,
        private readonly UserGroupRepositoryInterface $userGroupRepository
    ) {}

    public function __invoke(CreateGroupModel $groupModel): void
    {
        $users = $this->userDataRepository->findAllByUuids(...$groupModel->getUserUuids());

        $this->userGroupRepository->save(
            UserGroupFactory::create($groupModel, $users)
        );
    }
}