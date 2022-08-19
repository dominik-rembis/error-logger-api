<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Account\Application\Model\Query\AccountEntity;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\ObjectValue\Role;
use User\Account\Domain\Repository\AccountRepositoryInterface;

final class UserFinderTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02bb';
    private const REPOSITORY_METHOD = 'findOneByUuid';

    private AccountRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(AccountRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn(
            new Account(AccountUuid::generate(), 'anme', 'surname', 'email', 'password', Role::DEVELOPER)
        );

        $result = $this->executeHandler();

        $this->assertInstanceOf(Account::class, $result);
    }

    public function testCaseOfRecordsNotFound(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD);

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    private function executeHandler(): Account
    {
        $handler = new AccountEntityFinder($this->repository);
        return $handler->__invoke(new AccountEntity(self::EXAMPLE_UUID));
    }
}