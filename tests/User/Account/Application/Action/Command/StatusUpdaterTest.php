<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Account\Application\Model\Command\AccountStatus;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\ObjectValue\Role;

final class StatusUpdaterTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02bb';
    private const EXAMPLE_STATUS = true;

    private QueryBusInterface $queryBus;
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = self::createMock(QueryBusInterface::class);
        $this->persistence = self::createMock(PersistenceInterface::class);
    }
    
    public function testCaseOfUpdatingAccountStatus(): void
    {
        $this->queryBus->method('handle')->willReturn(self::getUserDataMock());

        $this->persistence->expects($this->once())->method('save')->with(
            self::callback(function (Account $object): bool {
                return self::propertyReader('isActive', $object);
            })
        );

        $handler = new StatusUpdater($this->queryBus, $this->persistence);
        $handler->__invoke(self::getAccountStatusMock());
    }

    private static function getUserDataMock(): Account
    {
        return new Account(
            AccountUuid::fromString(self::EXAMPLE_UUID),
            'name',
            'surname',
            'mail',
            'password',
            [Role::DEVELOPER],
            false
        );
    }

    private static function getAccountStatusMock(): AccountStatus
    {
        return new AccountStatus(self::EXAMPLE_UUID, self::EXAMPLE_STATUS);
    }
}