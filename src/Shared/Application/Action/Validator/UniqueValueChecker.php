<?php

declare(strict_types=1);

namespace Shared\Application\Action\Validator;

use Shared\Application\Exception\UnexpectedTypeException;
use Shared\Application\Model\Validator\UniqueValue;
use Shared\Domain\Repository\SharedRepositoryInterface;
use Shared\Infrastructure\Proxy\Validator\AbstractConstraintValidator;

final class UniqueValueChecker extends AbstractConstraintValidator
{
    public function __construct(
        private readonly SharedRepositoryInterface $repository
    ) {}

    public function verify(mixed $value): void
    {
        if (!$this->constraint instanceof UniqueValue) {
            throw new UnexpectedTypeException($this->constraint, UniqueValue::class);
        }

        $result = $this->repository->recordExist(
            $this->constraint->getEntityClass(),
            $this->constraint->getColumnName(),
            $value
        );

        if ($result) {
            $this
                ->context
                ->buildViolation($this->constraint->getMessage())
                ->addViolation();
        }
    }
}