<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Uuid;

use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

abstract class AbstractUuid extends AbstractUid
{
    protected function __construct(string $uuid)
    {
        $this->uid = $uuid;
    }

    public static function generate(): static
    {
        return new static((string) Uuid::v4());
    }

    public static function isValid(string $uid): bool
    {
        return Uuid::isValid($uid);
    }

    public static function fromString(string $uid): static
    {
        return new static($uid);
    }

    public function toBinary(): string
    {
        return Uuid::fromString($this->uid)->toBinary();
    }

    public function __toString(): string
    {
        return $this->toRfc4122();
    }
}