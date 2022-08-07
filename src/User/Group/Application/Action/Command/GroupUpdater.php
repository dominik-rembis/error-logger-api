<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Group\Application\Factory\UserGroupFactory;
use User\Group\Application\Model\Command\UpdateGroupModel;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class GroupUpdater
{
    public function __construct(
        private readonly UserDataRepositoryInterface $userDataRepository,
        private readonly UserGroupRepositoryInterface $userGroupRepository
    ) {}

    public function __invoke(UpdateGroupModel $groupModel): void
    {
        $group = $this->userGroupRepository->findOneByUuid($groupModel->getUuid());
        $users = $this->userDataRepository->findAllByUuids(...$groupModel->getUserUuids());

        $group->setProperties(
            UserGroupFactory::createPropertiesArray($groupModel, $users)
        );

        $this->userGroupRepository->save($group);
    }
}