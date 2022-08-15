<?php

declare(strict_types=1);

namespace Shared\Application\Strategy\Exception;

use Shared\Domain\Strategy\ExceptionStrategyInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class NotFoundStrategy implements ExceptionStrategyInterface
{
    public function __construct(
        private readonly \Throwable $throwable
    ) {}

    public function getResponse(): JsonResponse
    {
        return new JsonResponse(
            ($this->throwable?->getPrevious() ?? $this->throwable)->getMessage(),
            ($this->throwable?->getPrevious() ?? $this->throwable)->getCode()
        );
    }
}