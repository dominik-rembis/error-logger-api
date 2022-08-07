<?php

declare(strict_types=1);

namespace Shared\Application\Strategy\Exception;

use Shared\Domain\Strategy\ExceptionStrategyInterface;
use Shared\Infrastructure\Proxy\Response\JsonResponse;

final class ValidationFailedStrategy implements ExceptionStrategyInterface
{
    private const VALIDATION_STATUS_CODE = 422;

    public function __construct(
        private readonly \Throwable $throwable
    ) {}

    public function getResponse(): JsonResponse
    {
        return new JsonResponse(
            $this->prepareViolations(),
            self::VALIDATION_STATUS_CODE
        );
    }

    private function prepareViolations(): array
    {
        $result = [];
        foreach ($this->throwable->getViolations() as $violation) {
            $result[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $result;
    }
}