<?php

declare(strict_types=1);

namespace User\Data\Application\Model\Query;

use Shared\Application\Model\Query\QueryInterface;
use User\Data\Domain\ObjectValue\UserDataUuid;

final class AccountData implements QueryInterface
{
    public function __construct(
        private readonly string $uuid
    ) {}

    public function getUuid(): UserDataUuid
    {
        return UserDataUuid::fromString($this->uuid);
    }

    public function getLog(): string
    {
        return 'Searching user account data';
    }
}