<?php

declare(strict_types=1);

namespace Shared\Application\Model\Query;

interface QueryInterface
{
    public function getLog(): string;
}