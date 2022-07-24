<?php

declare(strict_types=1);

namespace Shared\Domain\ObjectValue;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuid;

final class ExampleUuidMock extends AbstractUuid
{
    public function __construct(string $uuid)
    {
        parent::__construct($uuid);
    }
}