<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Adapter\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Shared\Application\Model\Command\ExampleCommandMock;
use Shared\Application\Model\Command\ExampleCommandMockImplementingCommandInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\HttpFoundation\Request;

final class RequestParamConverterTest extends BaseTestCase
{
    private const PARAMETER_NAME = 'exampleClassMock';

    public function testCaseSupportForExampleObject(): void
    {
        $paramConverter = new ParamConverter(class: ExampleCommandMock::class);
        $requestParamConverter = new RequestParamConverter();

        $this->assertEquals(false, $requestParamConverter->supports($paramConverter));
    }

    public function testCaseSupportForObjectImplementingCommandInterface(): void
    {
        $paramConverter = new ParamConverter(class: ExampleCommandMockImplementingCommandInterface::class);
        $requestParamConverter = new RequestParamConverter();

        $this->assertEquals(true, $requestParamConverter->supports($paramConverter));
    }

    public function testCaseOfCreatingAnInstanceOfClassFromTransferredParametersInBody(): void
    {
        $request = new Request(content: '{"tmp": "buz", "foo": "fizz"}');
        $paramConverter = new ParamConverter(
            data: ['name' => self::PARAMETER_NAME],
            class: ExampleCommandMockImplementingCommandInterface::class
        );
        (new RequestParamConverter())->apply($request, $paramConverter);
        $parameter = $request->get(self::PARAMETER_NAME);

        $this->assertInstanceOf(ExampleCommandMockImplementingCommandInterface::class, $parameter);
        $this->assertEquals('buz', $parameter->getTmp());
        $this->assertEquals('fizz', $parameter->getFoo());
    }

    public function testCaseOfCreatingAnInstanceOfClassFromTransferredParametersInBodyAndRoute(): void
    {
        $request = new Request(
            attributes: ['_route_params' => ['tmp' => 'buz']],
            content: '{"foo": "fizz"}'
        );
        $paramConverter = new ParamConverter(
            data: ['name' => self::PARAMETER_NAME],
            class: ExampleCommandMockImplementingCommandInterface::class
        );
        (new RequestParamConverter())->apply($request, $paramConverter);
        $parameter = $request->get(self::PARAMETER_NAME);

        $this->assertInstanceOf(ExampleCommandMockImplementingCommandInterface::class, $parameter);
        $this->assertEquals('buz', $parameter->getTmp());
        $this->assertEquals('fizz', $parameter->getFoo());
    }
}