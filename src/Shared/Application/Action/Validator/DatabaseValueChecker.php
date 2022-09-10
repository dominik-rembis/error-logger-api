<?php

declare(strict_types=1);

namespace Shared\Application\Action\Validator;

use Shared\Application\Exception\UnexpectedTypeException;
use Shared\Application\Model\Validator\DatabaseValue;
use Shared\Domain\Repository\SharedRepositoryInterface;
use Shared\Infrastructure\Proxy\Validator\AbstractConstraintValidator;

final class DatabaseValueChecker extends AbstractConstraintValidator
{
    private const COLUMN_NAME = 'uuid';

    public function __construct(
        private readonly SharedRepositoryInterface $repository
    ) {}

    public function verify(mixed $value): void
    {
        if (!$this->constraint instanceof DatabaseValue) {
            throw new UnexpectedTypeException($this->constraint, DatabaseValue::class);
        }

        $result = $this->repository->recordExist(
            $this->constraint->getEntityClass(),
            self::COLUMN_NAME,
            $value
        );

        if (!$result) {
            $this
                ->context
                ->buildViolation($this->constraint->getMessage())
                ->addViolation();
        }
    }
}