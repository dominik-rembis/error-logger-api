<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Shared\Application\Model\Command\CommandInterface;
use Shared\Application\Model\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

final class RequestParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration): void
    {
        $parametersFromRequest = [
            ...$request->get('_route_params') ?? [],
            ...$request->getContent() ? $request->toArray() : []
        ];

        $modelClass = $configuration->getClass();
        $modelInstance = new $modelClass(...$parametersFromRequest);

        $request->attributes->set($configuration->getName(), $modelInstance);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return is_subclass_of($configuration->getClass(), CommandInterface::class)
            || is_subclass_of($configuration->getClass(), QueryInterface::class);
    }
}