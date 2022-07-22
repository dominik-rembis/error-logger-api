<?php

namespace Shared\Application\Proxy\MessageBus\Command;

use Shared\Application\Model\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}