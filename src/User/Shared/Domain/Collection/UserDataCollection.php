<?php

declare(strict_types=1);

namespace User\Shared\Domain\Collection;

use Shared\Infrastructure\Proxy\Collection\ArrayCollection;

final class UserDataCollection extends ArrayCollection
{
    public function __construct(array $users)
    {
        parent::__construct($users);
    }
}