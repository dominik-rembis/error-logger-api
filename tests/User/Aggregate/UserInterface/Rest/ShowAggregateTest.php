<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\ObjectValue\Role;
use User\Account\Infrastructure\Fixture\AccountData;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class ShowAggregateTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const SECOND_UUID = '0053bf63-cc69-48eb-9b1c-09f52185d627';

    private const ENDPOINT_PATH = '/user/aggregate/' . self::BASE_UUID;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfNotFindingAggregateData(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID, 'role' => Role::MANAGER]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::NOT_FOUND);
        $this->assertResponseJsonContent(
            '{"status":404,"message":"The searched value was not found."}',
            $this->client
        );
    }

    public function testCaseOfFindingAggregateData(): void
    {
        $this->loadFixtures([AggregateData::class => [
            'aggregateUuid' => self::BASE_UUID,
            'accountUuid' => self::SECOND_UUID,
            'accountRole' => Role::MANAGER
        ]]);

        $this->loginUser(['uuid' => self::SECOND_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":{"name":"exampleName","accounts":[{"uuid":"0053bf63-cc69-48eb-9b1c-09f52185d627","name":"exampleName","surname":"exampleSurname"}]}}',
            $this->client
        );
    }

    public function testCaseOfFindingGroupDataWhenAccountHasBeenInactive(): void
    {
        $this->loadFixtures([AggregateData::class => [
            'aggregateUuid' => self::BASE_UUID,
            'accountUuid' => self::BASE_UUID,
            'accountIsActive' => false,
            'accountRole' => Role::MANAGER
        ]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"data":{"name":"exampleName","accounts":[]}}', $this->client);
    }
}