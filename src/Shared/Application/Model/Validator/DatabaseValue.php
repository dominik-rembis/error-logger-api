<?php

declare(strict_types=1);

namespace Shared\Application\Model\Validator;

use Shared\Application\Action\Validator\DatabaseValueChecker;
use Shared\Infrastructure\Proxy\Validator\AbstractConstraint;

final class DatabaseValue extends AbstractConstraint
{
    protected string $message = 'This value not exists.';
    protected string $entityClass;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getValidatorClass(): string
    {
        return DatabaseValueChecker::class;
    }
}