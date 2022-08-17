<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Aggregate\Application\Model\Query\AggregateEntity;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;
use User\Aggregate\Domain\Repository\AggregateRepositoryInterface;
use User\Shared\Domain\Collection\AccountCollection;

final class AggregateFinderTest extends BaseTestCase
{
    private AggregateRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(AggregateRepositoryInterface::class);
    }

    public function testCaseOfFindingRecordsInTheDatabase(): void
    {
        $this->repository->method('findOneByUuid')->willReturn(new Aggregate(
            AggregateUuid::generate(),
            'example',
            new AccountCollection([])
        ));

        $handler = new AggregateEntityFinder($this->repository);
        $result = $handler->__invoke(self::getAggregateMock());

        $this->assertInstanceOf(Aggregate::class, $result);
    }

    public function testCaseOfNotFindingRecordsInTheDatabase(): void
    {
        $handler = new AggregateEntityFinder($this->repository);

        $this->expectException(NotFound::class);
        $handler->__invoke(self::getAggregateMock());
    }

    private static function getAggregateMock(): AggregateEntity
    {
        return new AggregateEntity('0053bf63-cc69-48eb-9b1c-09f52185d628');
    }
}