<?php

declare(strict_types=1);

namespace Shared\Application\Model\Query;

final class ExampleQueryMock
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