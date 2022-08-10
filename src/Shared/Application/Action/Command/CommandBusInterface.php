<?php

declare(strict_types=1);

namespace Shared\Application\Action\Command;

use Shared\Application\Model\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}