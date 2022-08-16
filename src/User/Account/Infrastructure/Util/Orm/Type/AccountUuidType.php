<?php

declare(strict_types=1);

namespace User\Account\Infrastructure\Util\Orm\Type;

use Shared\Infrastructure\Adapter\Uuid\AbstractUuidType;
use User\Account\Domain\ObjectValue\AccountUuid;

final class AccountUuidType extends AbstractUuidType
{
    public function getName(): string
    {
        return 'account_uuid';
    }

    protected function getUidClass(): string
    {
        return AccountUuid::class;
    }
}