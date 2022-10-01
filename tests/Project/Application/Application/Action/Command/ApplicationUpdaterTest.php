<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Command;

use Project\Application\Application\Model\Command\NewApplicationData;
use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\ObjectValue\AggregateUuid;
use Project\Application\Domain\ObjectValue\ApplicationUuid;
use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class ApplicationUpdaterTest extends BaseTestCase
{
    private const APPLICATION_UUID = '5521b951-4e41-4b1f-9415-6c70106f0062';
    private const AGGREGATE_UUID = 'efc43223-2f50-48c3-a1d0-1a2a3d3c6688';

    private QueryBusInterface $queryBus;
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = self::createMock(QueryBusInterface::class);
        $this->persistence = self::createMock(PersistenceInterface::class);
    }

    public function testCaseOfUpdatingApplication(): void
    {
        $this->queryBus->method('handle')->willReturn(self::getApplicationMock());

        $this->persistence->expects($this->once())->method('save')->with(
            self::callback(function (Application $object): bool {
                self::assertEquals('exampleName2', self::propertyReader('name', $object));
                self::assertEquals(
                    AggregateUuid::fromString(self::AGGREGATE_UUID),
                    self::propertyReader('aggregateUuid', $object)
                );

                return true;
            })
        );

        $handler = new ApplicationUpdater($this->queryBus, $this->persistence);
        $handler->__invoke(self::getNewApplicationDataMock());
    }

    private static function getApplicationMock(): Application
    {
        return new Application(
            ApplicationUuid::fromString(self::APPLICATION_UUID),
            'exampleName',
            AggregateUuid::fromString(self::AGGREGATE_UUID)
        );
    }

    private static function getNewApplicationDataMock(): NewApplicationData
    {
        return new NewApplicationData(
            self::APPLICATION_UUID,
            'exampleName2',
            self::AGGREGATE_UUID
        );
    }
}