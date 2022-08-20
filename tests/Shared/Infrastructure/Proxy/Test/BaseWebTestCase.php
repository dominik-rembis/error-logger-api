<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Proxy\Test;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use User\Account\Domain\Entity\Account;

abstract class BaseWebTestCase extends WebTestCase
{
    protected const GET = 'GET';
    protected const POST = 'POST';
    protected const PUT = 'PUT';

    protected const OK = 200;
    protected const CREATED = 201;
    protected const UNAUTHORIZED = 401;
    protected const NOT_FOUND = 404;
    protected const UNPROCESSABLE_ENTITY = 422;

    protected const JSON = 'json';

    public static function assertResponseJsonContent(
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

    public function assertInDatabase(
        string $entity,
        array $criteria,
        string $message = 'No records were found with the specified criteria'
    ): void
    {
        $this->assertTrue($this->databaseFinder($entity, $criteria), $message);
    }

    public function assertNotInDatabase(
        string $entity,
        array $criteria,
        string $message = 'Records were found with the specified criteria'
    ): void
    {
        $this->assertFalse($this->databaseFinder($entity, $criteria), $message);
    }

    public function loadFixtures(array $fixtures): void
    {
        $entityManager = (self::$kernel ?? self::bootKernel())
            ->getContainer()->get('doctrine.orm.entity_manager');

        foreach ($fixtures as $class => $context) {
            (new $class($context))->load($entityManager);
        }
    }

    public function loginUser(array $criteria, KernelBrowser $client): void
    {
        $entityManager = (self::$kernel ?? self::bootKernel())
            ->getContainer()->get('doctrine.orm.entity_manager');

        $client->loginUser(
            $entityManager->getRepository(Account::class)->findOneBy($criteria)
        );
    }

    private function databaseFinder(string $entity, array $criteria): bool
    {
        $entityManager = (self::$kernel ?? self::bootKernel())
            ->getContainer()->get('doctrine.orm.entity_manager');

        return (bool) $entityManager->getRepository($entity)->findOneBy($criteria);
    }
}