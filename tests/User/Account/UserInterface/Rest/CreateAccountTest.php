<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\Entity\Account;
use User\Account\Domain\ObjectValue\Role;
use User\Account\Infrastructure\Fixture\AccountData;

final class CreateAccountTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';

    private const ENDPOINT_PATH = '/user/account';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfCorrectUserAccountCreation(): void
    {
        $this->loadFixture();

        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, $body = [
            'name' => 'exampleName2',
            'surname' => 'exampleSurname2',
            'email' => 'example2@mail.com',
            'role' => 'ROLE_DEVELOPER'
        ]);

        unset($body['role']);
        $this->assertResponseStatusCodeSame(self::CREATED);
        $this->assertResponseJsonContent('{"status":201,"message":null}', $this->client);
        $this->assertInDatabase(Account::class, $body);
    }

    public function testCaseOfCreatingAccountForExistingEmailAddress(): void
    {
        $this->loadFixture();

        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, $body = [
            'name' => 'exampleName2',
            'surname' => 'exampleSurname2',
            'email' => 'example@mail.com',
            'role' => 'ROLE_DEVELOPER'
        ]);

        unset($body['role']);
        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"email":"This value already exists."}}',
            $this->client
        );
        $this->assertNotInDatabase(Account::class, $body);
    }

    public function testCaseForNoAuthentication(): void
    {
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, [
            'name' => 'exampleName2',
            'surname' => 'exampleSurname2',
            'email' => 'example@mail.com'
        ]);

        $this->assertResponseStatusCodeSame(self::UNAUTHORIZED);
    }

    private function loadFixture(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID, 'role' => Role::ADMINISTRATOR]]);
        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
    }
}