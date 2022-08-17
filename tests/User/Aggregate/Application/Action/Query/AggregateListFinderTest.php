<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Aggregate\Application\Dto\AggregateSummaryRow;
use User\Aggregate\Application\Model\Query\AggregateList;
use User\Aggregate\Domain\Repository\AggregateRepositoryInterface;

final class AggregateListFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findAllAggregateSummary';

    private AggregateRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(AggregateRepositoryInterface::class);
    }

    public function testCaseOfFindingRecordsInTheDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            [
                'uuid' => 'exampleUuid1',
                'name' => 'example',
                'accountCount' => 2,
            ]
        ]);

        $result = $this->executeHandler();

        $this->assertCount(1, $result);
        $this->assertContainsOnlyInstancesOf(AggregateSummaryRow::class, $result);
    }

    public function testCaseOfNotFindingRecordsInTheDatabase(): void
    {
        $result = $this->executeHandler();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testCaseOfCatchingThrownExceptionByRepository(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willThrowException(new \Exception());

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    private function executeHandler(): array
    {
        $handler = new AggregateListFinder($this->repository);
        return $handler->__invoke(new AggregateList());
    }
}