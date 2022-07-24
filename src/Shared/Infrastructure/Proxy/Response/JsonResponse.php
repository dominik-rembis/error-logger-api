<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Response;

use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

final class JsonResponse extends BaseJsonResponse
{
    public function __construct(mixed $data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct($data ?? ['status' => $status], $status, $headers, $json);
    }
}