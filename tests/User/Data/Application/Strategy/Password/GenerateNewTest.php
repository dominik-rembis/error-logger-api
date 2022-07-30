<?php

declare(strict_types=1);

namespace User\Data\Application\Strategy\Password;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class GenerateNewTest extends BaseTestCase
{
    public function testCaseOfReturningHashWhenNoContextPassed(): void
    {
        $password = (new GenerateNew())->getPassword();

        $this->assertEquals('argon2i', password_get_info($password)['algo']);
    }

    public function testCaseOfReturningPlainPasswordWhenContextIsPassed(): void
    {
        $password = (new GenerateNew())->getPassword(['plain' => true]);

        $this->assertEquals(12, strlen($password));
        $this->assertNull(password_get_info($password)['algo']);
    }
}