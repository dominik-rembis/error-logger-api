<?php

namespace Shared\Application\Model\Command;

interface CommandInterface
{
    public function getLog(): string;
}