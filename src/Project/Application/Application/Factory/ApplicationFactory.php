<?php

declare(strict_types=1);

namespace Project\Application\Application\Factory;

use Project\Application\Application\Model\Command\ApplicationData;
use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\ObjectValue\ApplicationUuid;

final class ApplicationFactory
{
    public static function create(ApplicationData $applicationData): Application
    {
        return new Application(
            ApplicationUuid::generate(),
            $applicationData->getName(),
            $applicationData->getAggregateUuid()
        );
    }
}