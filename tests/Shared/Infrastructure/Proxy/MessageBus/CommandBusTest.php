<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\MessageBus;

use Shared\Application\Model\Command\ExampleCommandMock;
use Shared\Application\Model\Command\ExampleCommandMockImplementingCommandInterface;
use Shared\Application\Action\Command\CommandBusInterface;
use Shared\Infrastructure\Proxy\Test\BaseKernelTestCase;

final class CommandBusTest extends BaseKernelTestCase
{
    private const EXPECTED_EXCEPTION_MESSAGE = 'Domain exception confirming correct connection';

    private ?CommandBusInterface $commandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = self::$container->get('shared.command.bus');
    }

    public function testCaseOfConnectionMessageWithHandler(): void
    {
        $this->expectExceptionMessage(self::EXPECTED_EXCEPTION_MESSAGE);
        $this->commandBus->dispatch(new ExampleCommandMockImplementingCommandInterface('tmp', 'foo'));
    }

    public function testCasePassingAnIncompatibleObject(): void
    {
        $this->expectError();
        $this->commandBus->dispatch(new ExampleCommandMock('tmp', 'foo'));
    }
}