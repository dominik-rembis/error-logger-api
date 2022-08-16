<?php

declare(strict_types=1);

namespace User\Group\Infrastructure\Fixture;

use Shared\Infrastructure\Adapter\Fixture\AbstractFixture;
use User\Data\Domain\Entity\UserData;
use User\Data\Domain\ObjectValue\UserDataUuid;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Domain\ObjectValue\UserGroupUuid;
use User\Shared\Domain\Collection\UserDataCollection;

final class Group extends AbstractFixture
{
    public function execute(array $context): void
    {
        $this->save(
            new UserGroup(
                UserGroupUuid::fromString($context['groupUuid']),
                $context['groupName'] ?? 'exampleName',
                new UserDataCollection([
                    new UserData(
                        isset($context['userUuid'])
                            ? UserDataUuid::fromString($context['userUuid'])
                            : UserDataUuid::generate(),
                        $context['userName'] ?? 'exampleName',
                        $context['userSurname'] ?? 'exampleSurname',
                        $context['userEmail'] ?? 'example@mail.com',
                        'exampleHash'
                    )
                ])
            )
        );
    }
}