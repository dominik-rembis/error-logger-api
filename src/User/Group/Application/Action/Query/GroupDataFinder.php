<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Group\Application\Dto\GroupDataRow;
use User\Group\Application\Dto\GroupUserRow;
use User\Group\Application\Model\Query\GroupData;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class GroupDataFinder
{
    public function __construct(
        private readonly UserGroupRepositoryInterface $repository
    ) {}

    public function __invoke(GroupData $groupData): GroupDataRow
    {
        try {
            $groupData = $this->repository->findGroupDataByUuid($groupData->getUuid());

            return new GroupDataRow(
                reset($groupData)['name'],
                array_map(
                    fn(array $user): GroupUserRow => new GroupUserRow(
                        $user['uuid'],
                        $user['firstname'],
                        $user['surname']
                    ),
                    $groupData
                )
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}