<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Group\Application\Model\Command\UpdateGroupModel;
use User\Group\Application\Model\Query\Group;
use User\Shared\Application\Model\Query\UserCollection;

final class GroupUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(UpdateGroupModel $groupModel): void
    {
        $group = $this->queryBus->handle(new Group($groupModel->getUuid()));
        $users = $this->queryBus->handle(new UserCollection($groupModel->getUserUuids()));

        $group->setProperties([
            'name' => $groupModel->getName(),
            'users' => $users
        ]);

        $this->persistence->save($group);
    }
}