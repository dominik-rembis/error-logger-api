<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Group\Application\Model\Command\GroupNewData;
use User\Group\Application\Model\Query\Group;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;
use User\Shared\Domain\Collection\UserDataCollection;

final class GroupUpdaterTest extends BaseTestCase
{
    private QueryBusInterface $queryBus;
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = self::createMock(QueryBusInterface::class);
        $this->persistence = self::createMock(PersistenceInterface::class);
    }

    public function testCaseOfUpdatingAccount(): void
    {
        $this->queryBus->method('handle')->willReturnCallback(function (object $object): object {
            if ($object instanceof Group) {
                return self::getUserGroupMock();
            }

            return new UserDataCollection([]);
        });

        $this->persistence
            ->expects($this->once())
            ->method('save')
            ->with(self::callback(fn(object $object): bool => $object instanceof UserGroup));

        $handler = new GroupUpdater($this->queryBus, $this->persistence);
        $handler->__invoke(self::getGroupNewDataMock());
    }

    private static function getUserGroupMock(): UserGroup
    {
        return new UserGroup(UserGroupUuid::generate(), 'example', new UserDataCollection([]));
    }

    private static function getGroupNewDataMock(): GroupNewData
    {
        return new GroupNewData(
            '6dca9476-1dd2-49ff-8fc3-4cbeed1e02bb',
            'example',
            ['0053bf63-cc69-48eb-9b1c-09f52185d628']
        );
    }
}