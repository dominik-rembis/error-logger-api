<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\Repository\AccountRepositoryInterface;
use User\Shared\Application\Model\Query\AccountCollection;
use User\Shared\Domain\Collection\AccountCollection as Collection;

final class AccountCollectionFinder
{
    public function __construct(
        private readonly AccountRepositoryInterface $repository
    ) {}

    public function __invoke(AccountCollection $accountCollection): Collection
    {
        $uuids = self::toObjectValue($accountCollection->getUuids());

        return new Collection(
            $this->repository->findAllByUuids(...$uuids)
        );
    }

    private static function toObjectValue(array $uuids): array
    {
        return array_map(fn(string $uuid): AccountUuid => AccountUuid::fromString($uuid), $uuids);
    }
}