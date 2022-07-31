<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

class NotFound extends \Exception
{
    public function __construct(string $message = 'The searched value was not found.')
    {
        parent::__construct($message, 404);
    }
}