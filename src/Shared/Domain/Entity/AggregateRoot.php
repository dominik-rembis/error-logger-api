<?php

declare(strict_types=1);

namespace Shared\Domain\Entity;

use Shared\Domain\Exception\InvalidProperty;

abstract class AggregateRoot
{
    /**
     * @param array<string, mixed> $values
     * @throws InvalidProperty
     */
    public function setProperties(array $values): static
    {
        $reflectionClass = new \ReflectionClass($this);

        try {
            foreach ($values as $property => $value) {
                $reflectionClass->getProperty($property)->setValue($this, $value);
            }
        } catch (\Throwable) {
            throw new InvalidProperty($property);
        }

        return $this;
    }
}