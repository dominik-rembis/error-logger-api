<?php

declare(strict_types=1);

namespace User\Group\Domain\ObjectValue;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuid;

final class UserGroupUuid extends AbstractUuid
{
    public function __construct(string $uuid)
    {
        parent::__construct($uuid);
    }
}