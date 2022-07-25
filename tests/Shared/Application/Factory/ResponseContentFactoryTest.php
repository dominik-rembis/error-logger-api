<?php

declare(strict_types=1);

namespace Shared\Application\Factory;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class ResponseContentFactoryTest extends BaseTestCase
{
    private static function getContent(mixed $data, int $status): array
    {
        return ResponseContentFactory::create($data, $status);
    }

    public function testCaseOfPassingTextOrBlankValue(): void
    {
        $text = 'example';
        $this->assertEquals(['status' => 200, 'message' => $text], self::getContent($text, 200));

        $this->assertEquals(['status' => 200, 'message' => null], self::getContent(null, 200));
        $this->assertEquals(['status' => 200, 'message' => ''], self::getContent('', 200));
    }

    public function testCaseOfPassingArrayOrObject(): void
    {
        $array = ['tmp' => 'foo'];
        $this->assertEquals(['status' => 300, 'data' => $array], self::getContent($array, 300));

        $object = new class() {};
        $this->assertEquals(['status' => 300, 'data' => $object], self::getContent($object, 300));
    }

    public function testCaseOfPassingArrayWithStatus422(): void
    {
        $violations = ['tmp' => 'foo'];
        $this->assertEquals(['status' => 422, 'validation' => $violations], self::getContent($violations, 422));
    }
}