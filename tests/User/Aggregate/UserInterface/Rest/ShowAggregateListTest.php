<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\ObjectValue\Role;
use User\Account\Infrastructure\Fixture\AccountData;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class ShowAggregateListTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';

    private const ENDPOINT_PATH = '/user/aggregate';

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfAccountAggregateListWasNotFound(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID, 'role' => Role::MANAGER]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"data":[]}', $this->client);
    }

    public function testCaseForFindingAccountAggregatesList(): void
    {
        $this->loadFixtures([AggregateData::class => [
            'aggregateUuid' => self::BASE_UUID,
            'accountUuid' => self::BASE_UUID,
            'accountRole' => Role::MANAGER
        ]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","accountCount":1}]}',
            $this->client
        );
    }

    public function testCaseOfFindingAggregateListWhenAccountHasBeenInactive(): void
    {
        $this->loadFixtures([AggregateData::class => [
            'aggregateUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba',
            'accountIsActive' => false,
            'accountUuid' => self::BASE_UUID,
            'accountRole' => Role::MANAGER
        ]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","accountCount":0}]}',
            $this->client
        );
    }
}