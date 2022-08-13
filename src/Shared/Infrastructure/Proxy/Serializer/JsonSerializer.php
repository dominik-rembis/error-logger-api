<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

final class JsonSerializer extends AbstractNormalizer implements SerializerInterface
{
    private const FORMAT = 'json';

    public static function serialize(mixed $data): string
    {
        return (new Serializer([self::getNormalizer()], [self::FORMAT => new JsonEncoder()]))
            ->serialize($data, self::FORMAT);
    }
}