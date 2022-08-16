<?php

namespace User\Data\Infrastructure\Fixture;

use Shared\Infrastructure\Adapter\Fixture\AbstractFixture;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;

class AccountData extends AbstractFixture
{
    public function execute(array $context): void
    {
        $this->save(
            new UserData(
                UserDataUuid::fromString($context['uuid']),
                $context['name'] ?? 'exampleName',
                $context['surname'] ?? 'exampleSurname',
                $context['email'] ??'example@mail.com',
                $context['password'] ?? 'exampleHash'
            )
        );
    }
}
