<?php

declare(strict_types=1);

namespace User\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Application\Action\Query\AccountListFinder;
use User\Data\Application\Dto\AccountDataRow;
use User\Data\Application\Model\Query\AccountList;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class AccountListFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findAllAccount';

    private UserDataRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserDataRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            [
                'uuid' => 'exampleUuid',
                'name' => 'exampleName',
                'surname' => 'exampleSurname',
            ], [
                'uuid' => 'exampleUuid',
                'name' => 'exampleName',
                'surname' => 'exampleSurname',
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