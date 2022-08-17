<?php

declare(strict_types=1);

namespace User\Aggregate\Application\Action\Command;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Aggregate\Application\Model\Command\AggregateNewData;
use User\Aggregate\Application\Model\Query\AggregateEntity;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;
use User\Shared\Domain\Collection\AccountCollection;

final class AggregateUpdaterTest extends BaseTestCase
{
    private QueryBusInterface $queryBus;
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = self::createMock(QueryBusInterface::class);
        $this->persistence = self::createMock(PersistenceInterface::class);
    }

    public function testCaseOfUpdatingAggregate(): void
    {
        $this->queryBus->method('handle')->willReturnCallback(function (object $object): object {
            if ($object instanceof AggregateEntity) {
                return self::getAggregateMock();
            }

            return new AccountCollection([]);
        });

        $this->persistence
            ->expects($this->once())
            ->method('save')
            ->with(self::callback(fn(object $object): bool => $object instanceof Aggregate));

        $handler = new AggregateUpdater($this->queryBus, $this->persistence);
        $handler->__invoke(self::getGroupNewDataMock());
    }

    private static function getAggregateMock(): Aggregate
    {
        return new Aggregate(AggregateUuid::generate(), 'example', new AccountCollection([]));
    }

    private static function getGroupNewDataMock(): AggregateNewData
    {
        return new AggregateNewData(
            '6dca9476-1dd2-49ff-8fc3-4cbeed1e02bb',
            'example',
            ['0053bf63-cc69-48eb-9b1c-09f52185d628']
        );
    }
}