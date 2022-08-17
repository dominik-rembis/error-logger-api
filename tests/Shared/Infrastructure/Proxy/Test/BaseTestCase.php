<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Test;

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    public static function propertyReader(string $property, object $object): mixed
    {
        return (new \ReflectionClass($object))->getProperty($property)->getValue($object);
    }
}