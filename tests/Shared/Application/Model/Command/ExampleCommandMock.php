<?php

declare(strict_types=1);

namespace Shared\Application\Model\Command;

final class ExampleCommandMock
{
    public function __construct(
        private readonly string $tmp,
        private readonly string $foo
    ) {}

    public function getTmp(): string
    {
        return $this->tmp;
    }

    public function getFoo(): string
    {
        return $this->foo;
    }
}