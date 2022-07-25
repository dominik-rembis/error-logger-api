<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventListener;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationFailed
{
    private const VALIDATION_STATUS_CODE = 422;

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationFailedException) {
            $event->setResponse(
                new JsonResponse(
                    self::processViolations($exception->getViolations()),
                    self::VALIDATION_STATUS_CODE
                )
            );
        }
    }

    private static function processViolations(ConstraintViolationListInterface $violationList): array
    {
        $result = [];
        foreach ($violationList as $violation) {
            $result[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $result;
    }
}