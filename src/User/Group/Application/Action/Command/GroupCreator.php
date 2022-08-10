<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Group\Application\Factory\UserGroupFactory;
use User\Group\Application\Model\Command\CreateGroupModel;
use User\Shared\Application\Model\Query\UserCollection;

final class GroupCreator
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(CreateGroupModel $groupModel): void
    {
        $users = $this->queryBus->handle(new UserCollection($groupModel->getUserUuids()));

        $this->persistence->save(
            UserGroupFactory::create($groupModel, $users)
        );
    }
}