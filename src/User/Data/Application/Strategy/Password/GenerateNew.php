<?php

declare(strict_types=1);

namespace User\Data\Application\Strategy\Password;

use User\Data\Domain\Service\TokenGenerator;
use User\Data\Domain\Strategy\PasswordStrategyInterface;

final class GenerateNew implements PasswordStrategyInterface
{
    private const PASSWORD_LENGTH = 12;

    public function getPassword(): string
    {
        return TokenGenerator::generate(self::PASSWORD_LENGTH);
    }
}