<?php

declare(strict_types=1);

namespace Shared\Application\Strategy\Exception;

use Shared\Domain\Strategy\ExceptionStrategyInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class AccessDeniedStrategy implements ExceptionStrategyInterface
{
    private const FORBIDDEN_STATUS_CODE = 403;

    public function __construct(
        private readonly \Throwable $throwable
    ) {}

    public function getResponse(): JsonResponse
    {
        return new JsonResponse(
            $this->throwable->getMessage(),
            self::FORBIDDEN_STATUS_CODE
        );
    }
}