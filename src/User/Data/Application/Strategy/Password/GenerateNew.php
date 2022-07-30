<?php

declare(strict_types=1);

namespace User\Data\Application\Strategy\Password;

use User\Data\Domain\Service\HashGenerator;
use User\Data\Domain\Service\TokenGenerator;
use User\Data\Domain\Strategy\PasswordStrategyInterface;

final class GenerateNew implements PasswordStrategyInterface
{
    private string $password;

    public function __construct()
    {
        $this->password = TokenGenerator::generate(12);
    }

    public function getPassword(array $context = []): string
    {
        return isset($context['plain']) && $context['plain']
            ? $this->password
            : HashGenerator::generate($this->password);
    }
}