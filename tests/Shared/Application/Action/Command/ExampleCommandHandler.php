<?php

namespace Shared\Application\Action\Command;

use Shared\Application\Model\Command\ExampleCommandMockImplementingCommandInterface;

final class ExampleCommandHandler
{
    public function __invoke(ExampleCommandMockImplementingCommandInterface $command): void
    {
        throw new \DomainException('Domain exception confirming correct connection');
    }
}