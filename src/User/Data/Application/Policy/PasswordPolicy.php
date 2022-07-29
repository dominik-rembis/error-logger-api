<?php

declare(strict_types=1);

namespace User\Data\Application\Policy;

use User\Data\Application\Strategy\Password\GenerateNew;
use User\Data\Application\Strategy\Password\ReturnOld;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Data\Domain\Repository\UserDataRepositoryInterface;
use User\Data\Domain\Strategy\PasswordStrategyInterface;

final class PasswordPolicy
{
    public static function apply(
        ?UserDataUuid $userDataUuid,
        UserDataRepositoryInterface $repository
    ): PasswordStrategyInterface
    {
        return $userDataUuid ? new ReturnOld($userDataUuid, $repository): new GenerateNew();
    }
}