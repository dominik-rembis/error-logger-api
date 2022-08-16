<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Group\Application\Model\Query\Group;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;
use User\Shared\Domain\Collection\AccountCollection;

final class GroupFinderTest extends BaseTestCase
{
    private UserGroupRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserGroupRepositoryInterface::class);
    }

    public function testCaseOfFindingRecordsInTheDatabase(): void
    {
        $this->repository->method('findOneByUuid')->willReturn(new UserGroup(
            UserGroupUuid::generate(),
            'example',
            new AccountCollection([])
        ));

        $handler = new GroupFinder($this->repository);
        $result = $handler->__invoke(self::getGroupMock());

        $this->assertInstanceOf(UserGroup::class, $result);
    }

    public function testCaseOfNotFindingRecordsInTheDatabase(): void
    {
        $handler = new GroupFinder($this->repository);

        $this->expectException(NotFound::class);
        $handler->__invoke(self::getGroupMock());
    }

    private static function getGroupMock(): Group
    {
        return new Group('0053bf63-cc69-48eb-9b1c-09f52185d628');
    }
}