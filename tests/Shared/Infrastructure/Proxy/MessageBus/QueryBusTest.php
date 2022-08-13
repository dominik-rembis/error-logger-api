<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\MessageBus;

use Shared\Application\Action\Query\QueryBusInterface;
use Shared\Application\Model\Query\ExampleQueryMock;
use Shared\Application\Model\Query\ExampleQueryMockImplementingQueryInterface;
use Shared\Infrastructure\Proxy\Test\BaseKernelTestCase;

final class QueryBusTest extends BaseKernelTestCase
{
    private const EXPECTED_EXCEPTION_MESSAGE = 'Domain exception confirming correct connection';

    private ?QueryBusInterface $queryBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = self::$container->get('shared.query.bus');
    }

    public function testCaseOfConnectionMessageWithHandler(): void
    {
        $this->expectExceptionMessage(self::EXPECTED_EXCEPTION_MESSAGE);
        $this->queryBus->handle(new ExampleQueryMockImplementingQueryInterface('tmp', 'foo'));
    }

    public function testCasePassingAnIncompatibleObject(): void
    {
        $this->expectError();
        $this->queryBus->handle(new ExampleQueryMock('tmp', 'foo'));
    }
}