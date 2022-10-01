<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Query;

use Project\Application\Application\Dto\ApplicationDataRow;
use Project\Application\Application\Model\Query\ApplicationData;
use Project\Application\Domain\Repository\ApplicationRepositoryInterface;
use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class ApplicationDataFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findDataByUuid';

    private ApplicationRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(ApplicationRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            'uuid' => '5521b951-4e41-4b1f-9415-6c70106f0062',
            'name' => 'exampleName',
            'aggregateUuid' => 'efc43223-2f50-48c3-a1d0-1a2a3d3c6688'
        ]);

        $result = $this->executeHandler();

        $this->assertInstanceOf(ApplicationDataRow::class, $result);
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

    private function executeHandler(): ApplicationDataRow
    {
        $handler = new ApplicationDataFinder($this->repository);
        return $handler->__invoke(self::createMock(ApplicationData::class));
    }
}