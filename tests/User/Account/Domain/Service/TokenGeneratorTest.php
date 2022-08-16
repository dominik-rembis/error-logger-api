<?php

declare(strict_types=1);

namespace User\Account\Domain\Service;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class TokenGeneratorTest extends BaseTestCase
{
    public function testCaseOfCheckingCorrectLength(): void
    {
        $token = TokenGenerator::generate(12);

        $this->assertEquals(12, strlen($token));
    }
}