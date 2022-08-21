<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Infrastructure\Fixture\AccountData;

final class ShowAccountDataTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const SECOND_UUID = '0266e820-82fa-4274-91fd-57281f45b87f';

    private const ENDPOINT_PATH = '/user/' . self::BASE_UUID . '/account';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfNotFindingAccountData(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::SECOND_UUID]]);

        $this->loginUser(['uuid' => self::SECOND_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::NOT_FOUND);
        $this->assertResponseJsonContent(
            '{"status":404,"message":"The searched value was not found."}',
            $this->client
        );
    }

    public function testCaseOfFindingAccountData(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","surname":"exampleSurname","status":true,"email":"example@mail.com"}}',
            $this->client
        );
    }

    public function testCaseOfFindingInactiveAccountData(): void
    {
        $this->loadFixtures([AccountData::class => [
            'uuid' => self::BASE_UUID,
            'isActive' => false
        ]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","surname":"exampleSurname","status":false,"email":"example@mail.com"}}',
            $this->client
        );
    }
}