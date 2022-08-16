<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use User\Group\Application\Factory\UserGroupFactory;
use User\Group\Application\Model\Command\GroupData;
use User\Shared\Application\Model\Query\AccountEntityCollection;

final class GroupCreator
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly PersistenceInterface $persistence
    ) {}

    public function __invoke(GroupData $groupData): void
    {
        $accountCollection = $this->queryBus->handle(new AccountEntityCollection($groupData->getUserUuids()));

        $this->persistence->save(
            UserGroupFactory::create($groupData, $accountCollection)
        );
    }
}