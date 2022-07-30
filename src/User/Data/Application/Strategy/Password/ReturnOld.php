<?php

declare(strict_types=1);

namespace User\Data\Application\Strategy\Password;

use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Data\Domain\Strategy\PasswordStrategyInterface;

final class ReturnOld implements PasswordStrategyInterface
{
    public function __construct(
        private readonly UserDataUuid $uuid,
        private readonly UserDataRepositoryInterface $repository
    ) {}

    public function getPassword(array $context = []): string
    {
        return $this->repository->findPasswordByUuid($this->uuid);
    }
}