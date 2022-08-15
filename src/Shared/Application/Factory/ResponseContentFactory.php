<?php

declare(strict_types=1);

namespace Shared\Application\Factory;

final class ResponseContentFactory
{
    public static function create(mixed $data, int $status): array
    {
        return [
            'status' => $status,
            ($status === 422 ? 'validation' : (is_string($data) || is_null($data) ? 'message' : 'data')) => $data
        ];
    }
}