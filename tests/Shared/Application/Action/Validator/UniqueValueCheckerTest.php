<?php

declare(strict_types=1);

namespace Shared\Application\Action\Validator;

use Shared\Application\Model\Validator\UniqueValue;
use Shared\Domain\Repository\SharedRepositoryInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class UniqueValueCheckerTest extends BaseTestCase
{
    private SharedRepositoryInterface $repository;
    private UniqueValue $uniqueValue;
    private ExecutionContextInterface $context;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(SharedRepositoryInterface::class);
        $this->uniqueValue = self::createMock(UniqueValue::class);
        $this->context = self::createMock(ExecutionContextInterface::class);
    }

    public function testCaseOfFoundRecordInDatabase(): void
    {
        $this->validate(true);
    }

    public function testCaseOfNotFoundRecordInDatabase(): void
    {
        $this->validate(false);
    }

    private function validate(bool $status): void
    {
        $this->repository->method('recordExist')->willReturn($status);
        $this->context->expects($status ? $this->once() : $this->never())
            ->method('buildViolation');

        $validator = new UniqueValueChecker($this->repository);
        $validator->initialize($this->context);
        $validator->validate('exampleValue', $this->uniqueValue);
    }
}