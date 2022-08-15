<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Test;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseWebTestCase extends WebTestCase
{
    protected const GET = 'GET';
    protected const POST = 'POST';
    protected const PUT = 'PUT';

    protected const OK = 200;
    protected const CREATED = 201;
    protected const NOT_FOUND = 404;
    protected const UNPROCESSABLE_ENTITY = 422;

    protected const JSON = 'json';

    protected static function assertResponseJsonContent(
        ?string $expected,
        KernelBrowser $client,
        string $message = ''
    ): void
    {
        self::assertResponseFormatSame(self::JSON);
        self::assertSame(
            $expected,
            $client->getResponse()->getContent(),
            $message
        );
    }

    protected function assertInDatabase(
        string $entity,
        array $criteria,
        string $message = 'No records were found with the specified criteria'
    ): void
    {
        $this->assertTrue($this->databaseFinder($entity, $criteria), $message);
    }

    protected function assertNotInDatabase(
        string $entity,
        array $criteria,
        string $message = 'Records were found with the specified criteria'
    ): void
    {
        $this->assertFalse($this->databaseFinder($entity, $criteria), $message);
    }

    protected function loadFixtures(array $fixtures): void
    {
        $entityManager = (self::$kernel ?? self::bootKernel())
            ->getContainer()->get('doctrine.orm.entity_manager');

        foreach ($fixtures as $class => $context) {
            (new $class($context))->load($entityManager);
        }
    }

    private function databaseFinder(string $entity, array $criteria): bool
    {
        $entityManager = (self::$kernel ?? self::bootKernel())
            ->getContainer()->get('doctrine.orm.entity_manager');

        return (bool) $entityManager->getRepository($entity)->findOneBy($criteria);
    }
}