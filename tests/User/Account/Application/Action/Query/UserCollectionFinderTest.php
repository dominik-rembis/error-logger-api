<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\Repository\AccountRepositoryInterface;
use User\Shared\Application\Model\Query\AccountEntityCollection;
use User\Shared\Domain\Collection\AccountCollection;

final class UserCollectionFinderTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const REPOSITORY_METHOD = 'findAllByUuids';

    private AccountRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(AccountRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            new Account(AccountUuid::generate(), 'anme', 'surname', 'email', 'password')
        ]);

        $result = $this->executeHandler();

        $this->assertCount(1, $result);
        $this->assertInstanceOf(AccountCollection::class, $result);
    }

    public function testCaseOfRecordsNotFound(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD);

        $result = $this->executeHandler();

        $this->assertCount(0, $result);
        $this->assertInstanceOf(AccountCollection::class, $result);
    }

    private function executeHandler(): AccountCollection
    {
        $handler = new AccountEntityCollectionFinder($this->repository);
        return $handler->__invoke(new AccountEntityCollection([self::EXAMPLE_UUID]));
    }
}