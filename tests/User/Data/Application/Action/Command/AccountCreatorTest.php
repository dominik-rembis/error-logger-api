<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Command;

use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Application\Model\Command\AccountData;
use User\Data\Domain\Entity\UserData;

final class AccountCreatorTest extends BaseTestCase
{
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->persistence = self::createMock(PersistenceInterface::class);
    }

    public function testCaseOfCreatingNewAccount(): void
    {
        $this->persistence
            ->expects($this->once())
            ->method('save')
            ->with(self::callback(fn(mixed $object): bool => $object instanceof UserData));

        $handler = new AccountCreator($this->persistence);
        $handler->__invoke(self::getAccountDataMock());
    }

    private static function getAccountDataMock(): AccountData
    {
        return new AccountData(
            'exampleName',
            'examplesurname',
            'example@mail.com',
        );
    }

}