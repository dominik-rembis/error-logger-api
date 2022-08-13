<?php

namespace Shared\Infrastructure\Proxy\Serializer;

interface SerializerInterface
{
    public static function serialize(mixed $data): string;
}