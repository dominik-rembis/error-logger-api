<?php

declare(strict_types=1);

namespace User\Account\Domain\Service;

final class HashGenerator
{
    public static function generate(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }
}