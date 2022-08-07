<?php

namespace Shared\Domain\Strategy;

use Shared\Infrastructure\Proxy\Response\JsonResponse;

interface ExceptionStrategyInterface
{
    public function getResponse(): JsonResponse;
}