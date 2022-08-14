<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Group\Application\Model\Command\GroupData;
use User\Group\Domain\Entity\UserGroup;
use User\Shared\Domain\Collection\UserDataCollection;

final class GroupCreatorTest extends BaseTestCase
{
    private QueryBusInterface $queryBus;
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = self::createMock(QueryBusInterface::class);
        $this->persistence = self::createMock(PersistenceInterface::class);
    }

    public function testCaseOfCreatingNewUserGroup(): void
    {
        $this->queryBus->method('handle')->willReturn(new UserDataCollection([]));
        $this->persistence
            ->expects($this->once())
            ->method('save')
            ->with(self::callback(fn(mixed $object): bool => $object instanceof UserGroup));

        $handler = new GroupCreator($this->queryBus, $this->persistence);
        $handler->__invoke(self::getAccountDataMock());
    }

    private static function getAccountDataMock(): GroupData
    {
        return new GroupData(
            'exampleName',
            ['0053bf63-cc69-48eb-9b1c-09f52185d628']
        );
    }

}