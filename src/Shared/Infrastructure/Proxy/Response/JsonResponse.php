<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Response;

use Shared\Application\Factory\ResponseContentFactory;
use Shared\Infrastructure\Proxy\Serializer\JsonSerializer;
use Symfony\Component\HttpFoundation\Response;

final class JsonResponse extends Response
{
    /** @param array<string, string> $headers */
    public function __construct(
        mixed $data = null,
        int $status = 200,
        array $headers = ['Content-Type' => 'application/json']
    ) {
        parent::__construct(
            JsonSerializer::serialize(ResponseContentFactory::create($data, $status)),
            $status,
            $headers
        );
    }
}