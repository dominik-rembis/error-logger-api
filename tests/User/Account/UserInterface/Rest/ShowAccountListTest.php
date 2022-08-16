<?php

declare(strict_types=1);

namespace User\Account\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Infrastructure\Fixture\AccountData;

final class ShowAccountListTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const SECOND_UUID = '258b114e-bfc2-44b1-bfc5-3964bcbde094';

    private const ENDPOINT_PATH = '/user/account';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfNotFindingUsers(): void
    {
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[]}',
            $this->client
        );
    }

    public function testCaseOfFindingAccountList(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID]]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","surname":"exampleSurname","status":true,"email":null}]}',
            $this->client
        );
    }

    public function testCaseWhenInactiveUserIsFoundInList(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID]]);
        $this->loadFixtures([AccountData::class => [
            'uuid' => self::SECOND_UUID,
            'email' => 'example2@mail.com',
            'isActive' => false
        ]]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"258b114e-bfc2-44b1-bfc5-3964bcbde094","name":"exampleName","surname":"exampleSurname","status":false,"email":null},{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","surname":"exampleSurname","status":true,"email":null}]}',
            $this->client
        );
    }
}