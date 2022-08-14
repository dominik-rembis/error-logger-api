<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Group\Application\Dto\GroupDataRow;
use User\Group\Application\Dto\GroupUserRow;
use User\Group\Application\Model\Query\GroupData;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class GroupDataFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findGroupDataByUuid';

    private UserGroupRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserGroupRepositoryInterface::class);
    }

    public function testCaseOfFindingRecordsInTheDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn(self::getDatabaseRecordsMock());

        $handler = new GroupDataFinder($this->repository);
        $result = $handler->__invoke(self::getGroupDataMock());

        $this->assertInstanceOf(GroupDataRow::class, $result);
        $this->assertSame('example', $result->getName());
        $this->assertCount(2, $result->getUsers());
        $this->assertContainsOnlyInstancesOf(GroupUserRow::class, $result->getUsers());
    }

    public function testCaseOfNotFindingRecordsInTheDatabase(): void
    {
        $handler = new GroupDataFinder($this->repository);

        $this->expectException(NotFound::class);
        $handler->__invoke(self::getGroupDataMock());
    }

    public function testCaseOfCatchingThrownExceptionByRepository(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willThrowException(new \Exception());

        $handler = new GroupDataFinder($this->repository);

        $this->expectException(NotFound::class);
        $handler->__invoke(self::getGroupDataMock());
    }

    private static function getDatabaseRecordsMock(): array
    {
        return [
            [
                'uuid' => 'exampleUuid1',
                'name' => 'example',
                'firstname' => 'exampleName1',
                'surname' => 'exampleSurname1',
            ], [
                'uuid' => 'exampleUuid2',
                'name' => 'example',
                'firstname' => 'exampleName2',
                'surname' => 'exampleSurname2',
            ]
        ];
    }

    private static function getGroupDataMock(): GroupData
    {
        return new GroupData('0053bf63-cc69-48eb-9b1c-09f52185d628');
    }
}