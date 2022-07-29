<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\Uuid;

use Symfony\Bridge\Doctrine\Types\AbstractUidType;

abstract class AbstractUuidType extends AbstractUidType
{
    abstract public function getName(): string;

    abstract protected function getUidClass(): string;
}