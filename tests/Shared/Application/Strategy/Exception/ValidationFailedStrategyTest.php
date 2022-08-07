<?php

declare(strict_types=1);

namespace Shared\Application\Strategy\Exception;

use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

final class ValidationFailedStrategyTest extends BaseTestCase
{
    private const EXPECTED_CONTENT = '{"status":422,"validation":{"exampleProperty":"example message"}}';

    public function testCaseOfReturningCorrectErrorResponse(): void
    {
        $strategy = new ValidationFailedStrategy(self::getExceptionMock());
        $response = $strategy->getResponse();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(self::EXPECTED_CONTENT, $response->getContent());
    }

    private static function getExceptionMock(): ValidationFailedException
    {
        return new ValidationFailedException(
            new class() {},
            new ConstraintViolationList([
                new ConstraintViolation(
                    message: 'example message',
                    messageTemplate: 'example message template',
                    parameters: [],
                    root: 'example',
                    propertyPath: 'exampleProperty',
                    invalidValue: 'example value'
                )
            ])
        );
    }
}