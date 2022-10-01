<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Query;

use Project\Application\Application\Model\Query\ApplicationEntity;
use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\ObjectValue\AggregateUuid;
use Project\Application\Domain\ObjectValue\ApplicationUuid;
use Project\Application\Domain\Repository\ApplicationRepositoryInterface;
use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class ApplicationFinderTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02bb';
    private const REPOSITORY_METHOD = 'findOneByUuid';

    private ApplicationRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(ApplicationRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn(
            new Application(ApplicationUuid::generate(), 'exampleName', AggregateUuid::generate())
        );

        $result = $this->executeHandler();

        $this->assertInstanceOf(Application::class, $result);
    }

    public function testCaseOfRecordsNotFound(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD);

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    private function executeHandler(): Application
    {
        $handler = new ApplicationEntityFinder($this->repository);
        return $handler->__invoke(new ApplicationEntity(self::EXAMPLE_UUID));
    }
}