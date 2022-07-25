<?php

declare(strict_types=1);

namespace Shared\Infrastructure;

use DG;
use PHPUnit\Runner\BeforeTestHook;

final class ByPassFinalHook implements BeforeTestHook
{
    public function executeBeforeTest(string $test): void
    {
        DG\BypassFinals::enable();
    }
}