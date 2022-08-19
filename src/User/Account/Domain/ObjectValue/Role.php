<?php

declare(strict_types=1);

namespace User\Account\Domain\ObjectValue;

enum Role: string
{
    case ADMINISTRATOR = 'ROLE_ADMINISTRATOR';
    case MANAGER = 'ROLE_MANAGER';
    case DEVELOPER = 'ROLE_DEVELOPER';
}