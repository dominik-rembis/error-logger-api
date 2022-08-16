<?php

declare(strict_types=1);

namespace User\Account\Domain\ObjectValue;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuid;

final class AccountUuid extends AbstractUuid
{
    public function __construct(string $uuid)
    {
        parent::__construct($uuid);
    }
}