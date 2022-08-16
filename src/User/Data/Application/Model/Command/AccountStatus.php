<?php

declare(strict_types=1);

namespace User\Data\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;

final class AccountStatus implements CommandInterface
{
    public function __construct(
        private readonly string $uuid,
        private readonly bool $isActive
    ) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function toArray(): array
    {
        return [
            'isActive' => $this->isActive
        ];
    }

    public function getLog(): string
    {
        return sprintf('Changing user account status about uuid: %s', $this->uuid);
    }
}