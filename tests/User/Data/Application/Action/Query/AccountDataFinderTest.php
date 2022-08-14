<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Application\Dto\AccountDataRow;
use User\Data\Application\Model\Query\AccountData;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class AccountDataFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findAccountDataByUuid';

    private UserDataRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserDataRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            'uuid' => 'exampleUuid',
            'name' => 'exampleName',
            'surname' => 'exampleSurname',
            'email' => 'example@mail.com'
        ]);

        $result = $this->executeHandler();

        $this->assertInstanceOf(AccountDataRow::class, $result);
    }

    public function testCaseOfRecordsNotFound(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD);

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    public function testCaseOfThrowExceptionByRepository(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willThrowException(new \Exception());

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    private function executeHandler(): AccountDataRow
    {
        $handler = new AccountDataFinder($this->repository);
        return $handler->__invoke(self::createMock(AccountData::class));
    }
}