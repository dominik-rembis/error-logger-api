<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class ShowAggregateListTest extends BaseWebTestCase
{
    private const ENDPOINT_PATH = '/user/aggregate';

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfAccountAggregateListWasNotFound(): void
    {
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"data":[]}', $this->client);
    }

    public function testCaseForFindingAccountAggregatesList(): void
    {
        $this->loadFixtures([AggregateData::class => ['aggregateUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba']]);

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
            'accountIsActive' => false
        ]]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","accountCount":0}]}',
            $this->client
        );
    }
}