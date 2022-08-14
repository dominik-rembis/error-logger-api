<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use User\Group\Application\Dto\GroupSummaryRow;
use User\Group\Application\Model\Query\GroupList;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class GroupListFinderTest extends BaseTestCase
{
    private const REPOSITORY_METHOD = 'findAllGroupSummary';

    private UserGroupRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::createMock(UserGroupRepositoryInterface::class);
    }

    public function testCaseOfFindingRecordsInTheDatabase(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willReturn([
            [
                'uuid' => 'exampleUuid1',
                'name' => 'example',
                'userCount' => 2,
            ]
        ]);

        $result = $this->executeHandler();

        $this->assertCount(1, $result);
        $this->assertContainsOnlyInstancesOf(GroupSummaryRow::class, $result);
    }

    public function testCaseOfNotFindingRecordsInTheDatabase(): void
    {
        $result = $this->executeHandler();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testCaseOfCatchingThrownExceptionByRepository(): void
    {
        $this->repository->method(self::REPOSITORY_METHOD)->willThrowException(new \Exception());

        $this->expectException(NotFound::class);
        $this->executeHandler();
    }

    private function executeHandler(): array
    {
        $handler = new GroupListFinder($this->repository);
        return $handler->__invoke(new GroupList());
    }
}