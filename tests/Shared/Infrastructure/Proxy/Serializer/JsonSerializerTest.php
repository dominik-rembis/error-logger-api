<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Serializer;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class JsonSerializerTest extends BaseTestCase
{
    public function testCaseOfArraySerialization(): void
    {
        $result = JsonSerializer::serialize(['tmp' => "foo"]);

        $this->assertEquals('{"tmp":"foo"}', $result);
    }

    public function testCaseOfObjectSerialization(): void
    {
        $result = JsonSerializer::serialize(self::getObjectMock());

        $this->assertEquals('{"tmp":"foo"}', $result);
    }

    public function testCaseOfNullSerialization(): void
    {
        $result = JsonSerializer::serialize(null);

        $this->assertEquals('null', $result);
    }

    private static function getObjectMock(): object
    {
        return new class() {
            public function getTmp(): string
            {
                return 'foo';
            }

            public function setTmp(): void
            {
                //Example logic
            }
        };
    }
}