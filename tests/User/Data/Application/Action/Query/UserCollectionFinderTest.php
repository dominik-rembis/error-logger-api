<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Query;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Shared\Application\Model\Query\UserCollection;
use User\Shared\Domain\Collection\UserDataCollection;

final class UserCollectionFinderTest extends BaseTestCase
{
    private const EXAMPLE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const REPOSITORY_METHOD = 'findAllByUuids';

    private UserDataRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserDataRepositoryInterface::class);
    }

    public function testCaseOfCorrectFindRecordsInDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            new UserData(UserDataUuid::generate(), 'anme', 'surname', 'email', 'password')
        ]);

        $result = $this->executeHandler();

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserDataCollection::class, $result);
    }

    public function testCaseOfRecordsNotFound(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD);

        $result = $this->executeHandler();

        $this->assertCount(0, $result);
        $this->assertInstanceOf(UserDataCollection::class, $result);
    }

    private function executeHandler(): UserDataCollection
    {
        $handler = new UserCollectionFinder($this->repository);
        return $handler->__invoke(new UserCollection([self::EXAMPLE_UUID]));
    }
}