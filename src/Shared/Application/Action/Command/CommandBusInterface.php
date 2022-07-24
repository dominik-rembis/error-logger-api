<?php

namespace Shared\Application\Action\Command;

use Shared\Application\Model\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}