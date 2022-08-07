<?php

declare(strict_types=1);

namespace Shared\Application\Strategy\Exception;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Response\JsonResponse;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class NotFoundStrategyTest extends BaseTestCase
{
    private const EXPECTED_CONTENT = '{"status":404,"message":"The searched value was not found."}';

    public function testCaseOfReturningCorrectErrorResponse(): void
    {
        $strategy = new NotFoundStrategy(self::getExceptionMock());
        $response = $strategy->getResponse();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(self::EXPECTED_CONTENT, $response->getContent());
    }

    private static function getExceptionMock(): \Exception
    {
        return new \Exception('Example Message', 500, new NotFound());
    }
}