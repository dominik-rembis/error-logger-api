<?php

declare(strict_types=1);

namespace User\Aggregate\Infrastructure\Fixture;

use Shared\Infrastructure\Adapter\Fixture\AbstractFixture;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\AccountUuid;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Domain\ObjectValue\AggregateUuid;
use User\Shared\Domain\Collection\AccountCollection;

final class AggregateData extends AbstractFixture
{
    public function execute(array $context): void
    {
        $this->save(
            new Aggregate(
                AggregateUuid::fromString($context['aggregateUuid']),
                $context['aggregateName'] ?? 'exampleName',
                new AccountCollection([
                    new Account(
                        isset($context['accountUuid'])
                            ? AccountUuid::fromString($context['accountUuid'])
                            : AccountUuid::generate(),
                        $context['accountName'] ?? 'exampleName',
                        $context['accountSurname'] ?? 'exampleSurname',
                        $context['accountEmail'] ?? 'example@mail.com',
                        'exampleHash',
                        $context['accountIsActive'] ?? true
                    )
                ])
            )
        );
    }
}