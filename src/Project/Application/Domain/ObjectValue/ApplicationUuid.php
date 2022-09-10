<?php

declare(strict_types=1);

namespace Project\Application\Domain\ObjectValue;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuid;

final class ApplicationUuid extends AbstractUuid
{
    public function __construct(string $uuid)
    {
        $this->uid = $uuid;
    }
}