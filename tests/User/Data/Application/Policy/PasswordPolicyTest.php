<?php

declare(strict_types=1);

namespace User\Data\Application\Policy;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Application\Strategy\Password\GenerateNew;
use User\Data\Application\Strategy\Password\ReturnOld;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class PasswordPolicyTest extends BaseTestCase
{
    private UserDataRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserDataRepositoryInterface::class);
    }

    public function testCaseForPassingUuidToPolicy(): void
    {
        $policy = PasswordPolicy::apply(UserDataUuid::generate(), $this->repository);

        $this->assertInstanceOf(ReturnOld::class, $policy);
    }

    public function testCaseForNotPassingUuidToPolicy(): void
    {
        $policy = PasswordPolicy::apply(null, $this->repository);

        $this->assertInstanceOf(GenerateNew::class, $policy);
    }
}