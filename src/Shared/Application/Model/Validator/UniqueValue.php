<?php

declare(strict_types=1);

namespace Shared\Application\Model\Validator;

use Shared\Application\Action\Validator\UniqueValueChecker;
use Shared\Infrastructure\Proxy\Validator\AbstractConstraint;

final class UniqueValue extends AbstractConstraint
{
    protected string $message = 'This value already exists.';
    protected string $entityClass;
    protected string $columnName = 'uuid';

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getValidatorClass(): string
    {
        return UniqueValueChecker::class;
    }
}