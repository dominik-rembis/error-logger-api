<?php

declare(strict_types=1);

namespace User\Group\Application\Action\Query;

use Shared\Domain\Exception\NotFound;
use User\Group\Application\Model\Query\Group;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\Repository\UserGroupRepositoryInterface;

final class GroupFinder
{
    public function __construct(
        private readonly UserGroupRepositoryInterface $repository
    ) {}

    public function __invoke(Group $group): UserGroup
    {
        $group = $this->repository->findOneByUuid($group->getUuid());

        return $group ?? throw new NotFound();
    }
}