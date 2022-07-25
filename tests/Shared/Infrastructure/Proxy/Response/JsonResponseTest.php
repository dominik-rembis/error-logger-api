<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Response;

use Shared\Infrastructure\Proxy\Test\BaseTestCase;
use Symfony\Component\HttpFoundation\Response;

final class JsonResponseTest extends BaseTestCase
{
    public function testCaseOfNotProvidingContent(): void
    {
        $response = new JsonResponse();

        $this->assertEquals('{"status":200,"message":null}', $response->getContent());
    }

    public function testCaseOfProvidingExampleContent(): void
    {
        $exampleContent = ['foo' => 'bar'];

        $response = new JsonResponse($exampleContent);

        $this->assertEquals('{"status":200,"data":{"foo":"bar"}}', $response->getContent());
    }

    public function testCaseOfCheckingProxyBaseClass(): void
    {
        $this->assertInstanceOf(Response::class, new JsonResponse());
    }
}