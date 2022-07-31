<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

class InvalidProperty extends \Exception
{
    public function __construct(string $property)
    {
        parent::__construct(sprintf('Invalid property %s.', $property), 400);
    }
}