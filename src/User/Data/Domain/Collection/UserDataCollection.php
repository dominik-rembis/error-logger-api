<?php

declare(strict_types=1);

namespace User\Data\Domain\Collection;

use Shared\Infrastructure\Proxy\Collection\ArrayCollection;
use User\Data\Domain\Entity\UserData;

final class UserDataCollection extends ArrayCollection
{
    public function __construct(UserData ...$userData)
    {
        parent::__construct($userData);
    }
}