<?php

declare(strict_types=1);

namespace User\Data\Application\Strategy\Password;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class GenerateNewTest extends BaseTestCase
{
    public function testCaseOfGeneratingPasswordOfAnAppropriateLength(): void
    {
        $password = (new GenerateNew())->getPassword();

        $this->assertEquals(12, strlen($password));
    }
}