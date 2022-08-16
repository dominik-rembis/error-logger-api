<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Group\Application\Model\Command\GroupNewData;
use User\Group\Application\Model\Query\Group;
use User\Shared\Application\Model\Query\AccountEntityCollection;

final class GroupUpdater
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(GroupNewData $groupNewData): void
    {
        $group = $this->queryBus->handle(new Group($groupNewData->getUuid()));
        $users = $this->queryBus->handle(new AccountEntityCollection($groupNewData->getUserUuids()));

        $group->setProperties([
            'name' => $groupNewData->getName(),
            'users' => $users
        ]);

        $this->persistence->save($group);
    }
}