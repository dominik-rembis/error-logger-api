<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\Entity\Account;
use User\Account\Infrastructure\Fixture\AccountData;

final class UpdateAccountTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const ENDPOINT_EXPRESSION = '/user/%s/account';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfUpdatingAccountWithTheSameEmailAddress(): void
    {
        $url = sprintf(self::ENDPOINT_EXPRESSION, self::BASE_UUID);

        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID]]);

        $this->client->jsonRequest(self::PUT, $url, $body = [
            'name' => 'exampleName',
            'surname' => 'exampleSurname',
            'email' => 'example@mail.com'
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
        $this->assertInDatabase(Account::class, $body);
    }

    public function testCaseOfUpdatingAccountWithTheAnotherEmailAddress(): void
    {
        $url = sprintf(self::ENDPOINT_EXPRESSION, self::BASE_UUID);

        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID]]);

        $this->client->jsonRequest(self::PUT, $url, $body = [
            'name' => 'exampleName',
            'surname' => 'exampleSurname',
            'email' => 'example2@mail.com'
        ]);

        $this->assertInDatabase(Account::class, $body);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
    }

    public function testCaseOfUpdatingAccountForBusyEmailAddress(): void
    {
        $url = sprintf(self::ENDPOINT_EXPRESSION, self::BASE_UUID);

        $this->loadFixtures([AccountData::class => [
            'uuid' => self::BASE_UUID,
            'email' => 'example@mail.com'
        ]]);
        $this->loadFixtures([AccountData::class => [
            'uuid' => '0053bf63-cc69-48eb-9b1c-09f52185d627',
            'name' => 'exampleName2',
            'surname' => 'exampleSurname2',
            'email' => 'example2@mail.com'
        ]]);

        $this->client->jsonRequest(self::PUT, $url, [
            'name' => 'exampleName',
            'surname' => 'exampleSurname',
            'email' => 'example2@mail.com'
        ]);

        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"email":"This value already exists."}}',
            $this->client
        );
        $this->assertNotInDatabase(Account::class, [
            'name' => 'exampleName',
            'surname' => 'exampleSurname',
            'email' => 'example2@mail.com'
        ]);
    }
}