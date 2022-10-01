<?php

declare(strict_types=1);

namespace Project\Application\UserInterface\Rest;

use Project\Application\Infrastructure\Fixture\ApplicationData;
use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Infrastructure\Fixture\AccountData;

final class ShowApplicationListTest extends BaseWebTestCase
{
    private const USER_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const APPLICATION_UUID = '0266e820-82fa-4274-91fd-57281f45b87f';

    private const ENDPOINT_PATH = '/project/application';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfFindingApplicationList(): void
    {
        $this->loadFixtures([
            AccountData::class => ['uuid' => self::USER_UUID],
            ApplicationData::class => ['applicationUuid' => self::APPLICATION_UUID]
        ]);

        $this->loginUser(['uuid' => self::USER_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"0266e820-82fa-4274-91fd-57281f45b87f","name":"exampleName","aggregateUuid":null}]}',
            $this->client
        );
    }

    public function testCaseOfNotFoundApplicationList(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::USER_UUID]]);

        $this->loginUser(['uuid' => self::USER_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[]}',
            $this->client
        );
    }

    public function testCaseForNoAuthentication(): void
    {
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::UNAUTHORIZED);
    }
}