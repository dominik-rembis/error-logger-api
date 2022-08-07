<?php

declare(strict_types=1);

namespace Shared\Application\Policy\Exception;

use Shared\Application\Strategy\Exception\NotFoundStrategy;
use Shared\Application\Strategy\Exception\ValidationFailedStrategy;
use Shared\Domain\Exception\NotFound;
use Shared\Domain\Strategy\ExceptionStrategyInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

final class ExceptionPolicy
{
    public static function create(\Throwable $throwable): ?ExceptionStrategyInterface
    {
        return match (get_class($throwable->getPrevious() ?? $throwable)) {
            ValidationFailedException::class => new ValidationFailedStrategy($throwable),
            NotFound::class => new NotFoundStrategy($throwable),
            default => null
        };
    }
}