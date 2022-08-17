<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\Entity\Account;
use User\Account\Infrastructure\Fixture\AccountData;

final class ChangeAccountStatusTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const ENDPOINT_PATH = '/user/' . self::BASE_UUID . '/status';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfChangingAccountToInactive(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID]]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, $body = [
            'isActive' => false
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
        $this->assertInDatabase(Account::class, $body);
    }

    public function testCaseOfChangingAccountToActive(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID, 'isActive' => false]]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, $body = [
            'isActive' => true
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
        $this->assertInDatabase(Account::class, $body);
    }

    public function testCaseOfAccountNotFounding(): void
    {
        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, [
            'isActive' => true
        ]);

        $this->assertResponseStatusCodeSame(self::NOT_FOUND);
        $this->assertResponseJsonContent(
            '{"status":404,"message":"The searched value was not found."}',
            $this->client
        );
    }
}