<?php

declare(strict_types=1);

namespace User\Data\Application\Model\Command;

use Shared\Application\Model\Command\CommandInterface;

final class CreateAccountDataModel implements CommandInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLog(): string
    {
        return sprintf('Creating user account about the e-mail address: %s', $this->email);
    }
}