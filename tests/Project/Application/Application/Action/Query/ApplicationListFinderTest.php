<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Query;

use Project\Application\Application\Dto\ApplicationDataRow;
use Project\Application\Application\Model\Query\ApplicationList;
use Project\Application\Domain\Repository\ApplicationRepositoryInterface;
use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class ApplicationListFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findAllApplication';

    private ApplicationRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(ApplicationRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            [
                'uuid' => '5521b951-4e41-4b1f-9415-6c70106f0062',
                'name' => 'exampleName',
                'aggregateUuid' => null
            ], [
                'uuid' => '5521b951-4e41-4b1f-9415-6c70106f0062',
                'name' => 'exampleName',
                'aggregateUuid' => null
            ]
        ]);

        $result = $this->executeHandler();

        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(ApplicationDataRow::class, $result);
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
        $handler = new ApplicationListFinder($this->repository);
        return $handler->__invoke(new ApplicationList());
    }
}