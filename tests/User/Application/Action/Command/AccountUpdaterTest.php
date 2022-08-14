<?php

declare(strict_types=1);

namespace User\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Application\Action\Command\AccountUpdater;
use User\Data\Application\Model\Command\NewAccountData;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class AccountUpdaterTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02bb';
    private const EXAMPLE_NAME = 'exampleName';
    private const EXAMPLE_SURNAME= 'exampleSurname';
    private const EXAMPLE_MAIL= 'example@mail.com';

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
        $this->queryBus->method('handle')->willReturn(self::getUserDataMock());

        $this->persistence->expects($this->once())->method('save')->with(
            self::callback(function (UserData $object): bool {
                self::assertEquals(self::EXAMPLE_NAME, self::propertyReader('name', $object));
                self::assertEquals(self::EXAMPLE_SURNAME, self::propertyReader('surname', $object));
                self::assertEquals(self::EXAMPLE_MAIL, self::propertyReader('email', $object));
                self::assertEquals('password', self::propertyReader('password', $object));

                return true;
            })
        );

        $handler = new AccountUpdater($this->queryBus, $this->persistence);
        $handler->__invoke(self::getAccountDataMock());
    }

    private static function getUserDataMock(): UserData
    {
        return new UserData(
            UserDataUuid::fromString(self::EXAMPLE_UUID),
            'name',
            'surname',
            'mail',
            'password'
        );
    }

    private static function propertyReader(string $property, UserData $object): string
    {
        return (new \ReflectionClass($object))
            ->getProperty($property)->getValue($object);
    }

    private static function getAccountDataMock(): NewAccountData
    {
        return new NewAccountData(
            self::EXAMPLE_UUID,
            self::EXAMPLE_NAME,
            self::EXAMPLE_SURNAME,
            self::EXAMPLE_MAIL,
        );
    }

}