<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class AbstractNormalizer
{
    protected static function getNormalizer(): ObjectNormalizer
    {
        return  new ObjectNormalizer(
            new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()))
        );
    }
}