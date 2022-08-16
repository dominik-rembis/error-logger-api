<?php

declare(strict_types=1);

namespace User\Group\Infrastructure\Fixture;

use Shared\Infrastructure\Adapter\Fixture\AbstractFixture;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;
use User\Shared\Domain\Collection\AccountCollection;

final class Group extends AbstractFixture
{
    public function execute(array $context): void
    {
        $this->save(
            new UserGroup(
                UserGroupUuid::fromString($context['groupUuid']),
                $context['groupName'] ?? 'exampleName',
                new AccountCollection([
                    new Account(
                        isset($context['userUuid'])
                            ? AccountUuid::fromString($context['userUuid'])
                            : AccountUuid::generate(),
                        $context['userName'] ?? 'exampleName',
                        $context['userSurname'] ?? 'exampleSurname',
                        $context['userEmail'] ?? 'example@mail.com',
                        'exampleHash',
                        $context['userIsActive'] ?? true
                    )
                ])
            )
        );
    }
}