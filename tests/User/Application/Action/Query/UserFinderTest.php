<?php

declare(strict_types=1);

namespace User\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Application\Action\Query\UserFinder;
use User\Data\Application\Model\Query\User;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;

final class UserFinderTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02bb';
    private const REPOSITORY_METHOD = 'findOneByUuid';

    private UserDataRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserDataRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn(
            new UserData(UserDataUuid::generate(), 'anme', 'surname', 'email', 'password')
        );

        $result = $this->executeHandler();

        $this->assertInstanceOf(UserData::class, $result);
    }

    public function testCaseOfRecordsNotFound(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD);

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    private function executeHandler(): UserData
    {
        $handler = new UserFinder($this->repository);
        return $handler->__invoke(new User(self::EXAMPLE_UUID));
    }
}