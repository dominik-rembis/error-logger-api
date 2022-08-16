<?php

declare(strict_types=1);

namespace User\Account\Domain\Service;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class HashGeneratorTest extends BaseTestCase
{
    private const EXAMPLE_PASSWORD = 'zaq1@WSX';
    private const EXPECTED_ALGORITHM = 'argon2i';

    public function testCaseOfCorrectnessHashedPassword(): void
    {
        $hash = HashGenerator::generate(self::EXAMPLE_PASSWORD);

        $this->assertEquals(true, password_verify(self::EXAMPLE_PASSWORD, $hash));
    }

    public function testCaseOfCheckingTheHashAlgorithm(): void
    {
        $hash = HashGenerator::generate(self::EXAMPLE_PASSWORD);
        $hashInfo = password_get_info($hash);

        $this->assertEquals(self::EXPECTED_ALGORITHM, $hashInfo['algo']);
    }
}