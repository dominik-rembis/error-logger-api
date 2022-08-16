<?php

namespace User\Account\Infrastructure\Fixture;

use Shared\Infrastructure\Adapter\Fixture\AbstractFixture;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;

class AccountData extends AbstractFixture
{
    public function execute(array $context): void
    {
        $this->save(
            new Account(
                AccountUuid::fromString($context['uuid']),
                $context['name'] ?? 'exampleName',
                $context['surname'] ?? 'exampleSurname',
                $context['email'] ??'example@mail.com',
                $context['password'] ?? 'exampleHash',
                $context['isActive'] ?? true
            )
        );
    }
}
