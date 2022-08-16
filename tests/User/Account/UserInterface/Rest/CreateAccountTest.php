<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\Entity\Account;
use User\Account\Infrastructure\Fixture\AccountData;

final class CreateAccountTest extends BaseWebTestCase
{
    private const ENDPOINT_PATH = '/user/account';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfCorrectUserAccountCreation(): void
    {
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, $body = [
            'name' => 'exampleName',
            'surname' => 'exampleSurname',
            'email' => 'example@mail.com'
        ]);

        $this->assertResponseStatusCodeSame(self::CREATED);
        $this->assertResponseJsonContent('{"status":201,"message":null}', $this->client);
        $this->assertInDatabase(Account::class, $body);
    }

    public function testCaseOfCreatingAccountForExistingEmailAddress(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba']]);

        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, $body = [
            'name' => 'exampleName2',
            'surname' => 'exampleSurname2',
            'email' => 'example@mail.com'
        ]);

        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"email":"This value already exists."}}',
            $this->client
        );
        $this->assertNotInDatabase(Account::class, $body);
    }
}