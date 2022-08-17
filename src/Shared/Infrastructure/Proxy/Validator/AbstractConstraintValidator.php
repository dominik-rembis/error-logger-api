<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

abstract class AbstractConstraintValidator extends ConstraintValidator
{
    protected Constraint $constraint;

    abstract public function verify(mixed $value): void;

    public function validate(mixed $value, Constraint $constraint): void
    {
        $this->constraint = &$constraint;
        $this->verify($value);
    }
}