<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Aggregate\Application\Model\Command\AggregateData;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Shared\Domain\Collection\AccountCollection;

final class AggregateCreatorTest extends BaseTestCase
{
    private QueryBusInterface $queryBus;
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = self::createMock(QueryBusInterface::class);
        $this->persistence = self::createMock(PersistenceInterface::class);
    }

    public function testCaseOfCreatingNewAggregate(): void
    {
        $this->queryBus->method('handle')->willReturn(new AccountCollection([]));
        $this->persistence
            ->expects($this->once())
            ->method('save')
            ->with(self::callback(fn(mixed $object): bool => $object instanceof Aggregate));

        $handler = new AggregateCreator($this->queryBus, $this->persistence);
        $handler->__invoke(self::getAggregateDataMock());
    }

    private static function getAggregateDataMock(): AggregateData
    {
        return new AggregateData(
            'exampleName',
            ['0053bf63-cc69-48eb-9b1c-09f52185d628']
        );
    }

}