<?php

declare(strict_types=1);

namespace User\Account\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;
use User\Account\Domain\ObjectValue\AccountUuid;

final class AccountEntity implements QueryInterface
{
    public function __construct(
        private readonly string $uuid
    ) {}

    public function getUuid(): AccountUuid
    {
        return AccountUuid::fromString($this->uuid);
    }

    public function getLog(): string
    {
        return sprintf('Searching account entity with uuid: %s.', $this->uuid);
    }
}