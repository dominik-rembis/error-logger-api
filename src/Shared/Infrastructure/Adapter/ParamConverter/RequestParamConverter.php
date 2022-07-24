<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Shared\Application\Model\Command\CommandInterface;
use Symfony\Component\HttpFoundation\Request;

final class RequestParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration): void
    {
        $parametersFromRequest = [...$request->get('_route_params') ?? [], ...$request->toArray()];

        $modelClass = $configuration->getClass();
        $modelInstance = new $modelClass(...$parametersFromRequest);

        $request->attributes->set($configuration->getName(), $modelInstance);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return is_subclass_of($configuration->getClass(), CommandInterface::class);
    }
}