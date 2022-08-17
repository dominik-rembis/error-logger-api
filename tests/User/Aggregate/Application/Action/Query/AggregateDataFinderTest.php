<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Aggregate\Application\Dto\AggregateAccountRow;
use User\Aggregate\Application\Dto\AggregateDataRow;
use User\Aggregate\Application\Model\Query\AggregateData;
use User\Aggregate\Domain\Repository\AggregateRepositoryInterface;

final class AggregateDataFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findAggregateDataByUuid';

    private AggregateRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(AggregateRepositoryInterface::class);
    }

    public function testCaseOfFindingRecordsInTheDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn(self::getDatabaseRecordsMock());

        $handler = new AggregateDataFinder($this->repository);
        $result = $handler->__invoke(self::getAggregateDataMock());

        $this->assertInstanceOf(AggregateDataRow::class, $result);
        $this->assertSame('example', $result->getName());
        $this->assertCount(2, $result->getAccounts());
        $this->assertContainsOnlyInstancesOf(AggregateAccountRow::class, $result->getAccounts());
    }

    public function testCaseOfNotFindingRecordsInTheDatabase(): void
    {
        $handler = new AggregateDataFinder($this->repository);

        $this->expectException(NotFound::class);
        $handler->__invoke(self::getAggregateDataMock());
    }

    public function testCaseOfCatchingThrownExceptionByRepository(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willThrowException(new \Exception());

        $handler = new AggregateDataFinder($this->repository);

        $this->expectException(NotFound::class);
        $handler->__invoke(self::getAggregateDataMock());
    }

    private static function getDatabaseRecordsMock(): array
    {
        return [
            [
                'uuid' => 'exampleUuid1',
                'name' => 'example',
                'firstname' => 'exampleName1',
                'surname' => 'exampleSurname1',
                'status' => 1
            ], [
                'uuid' => 'exampleUuid2',
                'name' => 'example',
                'firstname' => 'exampleName2',
                'surname' => 'exampleSurname2',
                'status' => 1
            ]
        ];
    }

    private static function getAggregateDataMock(): AggregateData
    {
        return new AggregateData('0053bf63-cc69-48eb-9b1c-09f52185d628');
    }
}