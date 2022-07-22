<?php

declare(strict_types=1);

namespace User\Data\Domain\Service;

final class TokenGenerator
{
    public static function generate(int $length = 10): string
    {
        return bin2hex(
            openssl_random_pseudo_bytes($length / 2)
        );
    }
}