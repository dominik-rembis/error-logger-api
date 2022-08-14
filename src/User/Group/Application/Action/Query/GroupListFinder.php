<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Group\Application\Dto\GroupSummaryRow;
use User\Group\Application\Model\Query\GroupList;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class GroupListFinder
{
    public function __construct(
        private readonly UserGroupRepositoryInterface $repository
    ) {}

    public function __invoke(GroupList $groupList): array
    {
        try {
            return array_map(
                fn(array $summary): GroupSummaryRow => new GroupSummaryRow(...$summary),
                $this->repository->findAllGroupSummary()
            );
        } catch (\Throwable) {
            throw new NotFound();
        }
    }
}