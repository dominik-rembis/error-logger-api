<?php

declare(strict_types=1);

namespace User\Account\Application\Action\Query;

use User\Account\Domain\ObjectValue\AccountUuid;
use User\Account\Domain\Repository\AccountRepositoryInterface;
use User\Shared\Application\Model\Query\AccountEntityCollection;
use User\Shared\Domain\Collection\AccountCollection;

final class AccountEntityCollectionFinder
{
    public function __construct(
        private readonly AccountRepositoryInterface $repository
    ) {}

    public function __invoke(AccountEntityCollection $accountEntityCollection): AccountCollection
    {
        $uuids = self::toObjectValue($accountEntityCollection->getUuids());

        return new AccountCollection(
            $this->repository->findAllByUuids(...$uuids)
        );
    }

    private static function toObjectValue(array $uuids): array
    {
        return array_map(fn(string $uuid): AccountUuid => AccountUuid::fromString($uuid), $uuids);
    }
}