<?php

namespace Project\Application\Domain\Repository;

use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\ObjectValue\ApplicationUuid;

interface ApplicationRepositoryInterface
{
    public function findOneByUuid(ApplicationUuid $uuid): ?Application;

    public function findAllApplication(): array;

    public function findDataByUuid(ApplicationUuid $uuid): array;
}