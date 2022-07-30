<?php

declare(strict_types=1);

namespace User\Data\Domain\Strategy;

interface PasswordStrategyInterface
{
    public function getPassword(array $context = []): string;
}