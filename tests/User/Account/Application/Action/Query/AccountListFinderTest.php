<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Account\Application\Dto\AccountDataRow;
use User\Account\Application\Model\Query\AccountList;
use User\Account\Domain\Repository\AccountRepositoryInterface;

final class AccountListFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findAllAccount';

    private AccountRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(AccountRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            [
                'uuid' => 'exampleUuid',
                'name' => 'exampleName',
                'surname' => 'exampleSurname',
                'status' => 1
            ], [
                'uuid' => 'exampleUuid',
                'name' => 'exampleName',
                'surname' => 'exampleSurname',
                'status' => 1
            ]
        ]);

        $result = $this->executeHandler();

        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(AccountDataRow::class, $result);
    }

    public function testCaseOfRecordsNotFound(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD);

        $result = $this->executeHandler();

        $this->assertEmpty($result);
    }

    public function testCaseOfThrowExceptionByRepository(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willThrowException(new \Exception());

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    private function executeHandler(): array
    {
        $handler = new AccountListFinder($this->repository);
        return $handler->__invoke(new AccountList());
    }
}