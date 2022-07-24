<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Uuid;

use Shared\Domain\ObjectValue\ExampleUuidMock;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\Uid\AbstractUid;

final class AbstractUuidTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '0d5cbc9c-adf7-402a-9d40-7d4e646ba628';

    public function testCaseOfReturningCorrectTypeofChild(): void
    {
        $this->assertInstanceOf(ExampleUuidMock::class, ExampleUuidMock::generate());
        $this->assertInstanceOf(ExampleUuidMock::class, ExampleUuidMock::fromString(self::EXAMPLE_UUID));
    }

    public function testCaseOdValidationUuid(): void
    {
        $this->assertEquals(true, ExampleUuidMock::isValid(self::EXAMPLE_UUID));
        $this->assertEquals(true, ExampleUuidMock::isValid(strtoupper(self::EXAMPLE_UUID)));
        $this->assertEquals(false, ExampleUuidMock::isValid(substr(self::EXAMPLE_UUID, 1)));
        $this->assertEquals(false, ExampleUuidMock::isValid(
            str_replace('-', '', self::EXAMPLE_UUID)
        ));
    }

    public function testCaseOdClassContainsCompatibleBaseClass(): void
    {
        $this->assertInstanceOf(AbstractUid::class, ExampleUuidMock::generate());
    }
}