<?php

declare(strict_types=1);

namespace User\Data\Application\Action\Query;

use User\Shared\Domain\Collection\UserDataCollection;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Shared\Application\Model\Query\UserCollection;

final class UserCollectionFinder
{
    public function __construct(
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function __invoke(UserCollection $userCollection): UserDataCollection
    {
        $uuids = self::toObjectValue($userCollection->getUuids());

        return new UserDataCollection(
            $this->repository->findAllByUuids(...$uuids)
        );
    }

    private static function toObjectValue(array $uuids): array
    {
        return array_map(fn(string $uuid): UserDataUuid => UserDataUuid::fromString($uuid), $uuids);
    }
}