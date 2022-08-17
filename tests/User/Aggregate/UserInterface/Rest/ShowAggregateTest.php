<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class ShowAggregateTest extends BaseWebTestCase
{
    private const ENDPOINT_PATH = '/user/aggregate/6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfNotFindingAggregateData(): void
    {
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
            'aggregateUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba',
            'accountUuid' => '0053bf63-cc69-48eb-9b1c-09f52185d627'
        ]]);

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
            'aggregateUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba',
            'accountUuid' => '0053bf63-cc69-48eb-9b1c-09f52185d627',
            'accountIsActive' => false
        ]]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"data":{"name":"exampleName","accounts":[]}}', $this->client);
    }
}