<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\MessageBus\Command;

use Shared\Application\Model\Command\CommandInterface;
use Shared\Application\Proxy\MessageBus\Command\CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {}

    public function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}