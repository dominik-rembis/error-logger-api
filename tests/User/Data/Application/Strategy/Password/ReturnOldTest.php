<?php

declare(strict_types=1);

namespace User\Data\Application\Strategy\Password;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class ReturnOldTest extends BaseTestCase
{
    private const PASSWORD = 'examplePassword';

    public function testCaseOfReturningTheOldPassword(): void
    {
        $repository = self::createMock(UserDataRepositoryInterface::class);
        $repository->method('findPasswordByUuid')->willReturn(self::PASSWORD);

        $password = (new ReturnOld(UserDataUuid::generate(), $repository))->getPassword();

        $this->assertSame(self::PASSWORD, $password);
    }
}