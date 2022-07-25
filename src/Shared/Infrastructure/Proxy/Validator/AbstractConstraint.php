<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Validator;

use Symfony\Component\Validator\Constraint;

abstract class AbstractConstraint extends Constraint
{
    abstract public function getMessage(): string;

    abstract public function getValidatorClass(): string;

    public function validatedBy(): string
    {
        return $this->getValidatorClass();
    }
}