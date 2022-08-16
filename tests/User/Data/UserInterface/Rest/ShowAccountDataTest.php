<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Data\Infrastructure\Fixture\AccountData;

final class ShowAccountDataTest extends BaseWebTestCase
{
    private const ENDPOINT_PATH = '/user/list';

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
        $this->loadFixtures([AccountData::class => ['uuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba']]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","surname":"exampleSurname","email":null}]}',
            $this->client
        );
    }
}