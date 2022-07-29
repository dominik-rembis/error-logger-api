<?php

declare(strict_types=1);

namespace User\Data\Domain\ObjectValue;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuid;

final class UserDataUuid extends AbstractUuid
{
    public function __construct(string $uuid)
    {
        parent::__construct($uuid);
    }
}