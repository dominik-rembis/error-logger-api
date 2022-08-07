<?php

declare(strict_types=1);

namespace Shared\Application\Policy\Exception;

use Shared\Application\Strategy\Exception\NotFoundStrategy;
use Shared\Application\Strategy\Exception\ValidationFailedStrategy;
use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ExceptionPolicyTest extends BaseTestCase
{
    public function testCaseOfFoundNotFoundStrategy(): void
    {
        $exception = new \Exception('example message', 500, new NotFound());

        $policy = ExceptionPolicy::create($exception);

        $this->assertInstanceOf(NotFoundStrategy::class, $policy);
    }

    public function testCaseOfFoundValidationFailedStrategy(): void
    {
        $exception = new ValidationFailedException(
            new class() {},
            self::createMock(ConstraintViolationListInterface::class)
        );

        $policy = ExceptionPolicy::create($exception);

        $this->assertInstanceOf(ValidationFailedStrategy::class, $policy);
    }

    public function testCaseOfNotFoundCorrectStrategy(): void
    {
        $exception = new \Exception('example message', 500);

        $policy = ExceptionPolicy::create($exception);

        $this->assertNull($policy);
    }
}