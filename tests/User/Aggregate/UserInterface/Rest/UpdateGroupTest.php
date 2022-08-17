<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Infrastructure\Fixture\AccountData;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class UpdateGroupTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const SECOND_UUID = '0266e820-82fa-4274-91fd-57281f45b87f';
    private const THIRD_UUID = '0053bf63-cc69-48eb-9b1c-09f52185d627';

    private const ENDPOINT_PATH = '/user/aggregate/' . self::BASE_UUID;

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfCorrectAggregateNameChange(): void
    {
        $this->loadFixtures([AggregateData::class => ['aggregateUuid' => self::BASE_UUID]]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, $body = [
            'name' => 'exampleName2'
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
        $this->assertInDatabase(Aggregate::class, $body);
    }

    public function testCaseOfChangingAggregateNameToExistingOne(): void
    {
        $this->loadFixtures([AggregateData::class => ['aggregateUuid' => self::BASE_UUID]]);
        $this->loadFixtures([AggregateData::class => [
            'aggregateUuid' => self::SECOND_UUID,
            'aggregateName' => 'exampleName2',
            'accountEmail' => 'example2@mail.com'
        ]]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, [
            'name' => 'exampleName2'
        ]);

        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"name":"This value already exists."}}',
            $this->client
        );
        $this->assertNotInDatabase(Aggregate::class, [
            'uuid' => self::BASE_UUID,
            'name' => 'exampleName2'
        ]);
    }

    public function testCaseOfAssigningNewAccountToAggregate(): void
    {
        $this->loadFixtures([
            AggregateData::class => ['aggregateUuid' => self::BASE_UUID, 'accountUuid' => self::SECOND_UUID],
            AccountData::class => ['uuid' => self::THIRD_UUID, 'email' => 'example2@mail.com']
        ]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, [
            'name' => 'example',
            'accountUuids' => [self::SECOND_UUID, self::THIRD_UUID]
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
    }

    public function testCaseOfRemovingUserFromAggregate(): void
    {
        $this->loadFixtures([
            AggregateData::class => ['aggregateUuid' => self::BASE_UUID, 'accountUuid' => self::SECOND_UUID]
        ]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, [
            'name' => 'example',
            'accountUuids' => []
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
    }
}