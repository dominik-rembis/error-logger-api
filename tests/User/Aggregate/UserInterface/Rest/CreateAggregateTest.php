<?php

declare(strict_types=1);

namespace User\Aggregate\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\ObjectValue\Role;
use User\Account\Infrastructure\Fixture\AccountData;
use User\Aggregate\Domain\Entity\Aggregate;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class CreateAggregateTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const ENDPOINT_PATH = '/user/aggregate';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }
    public function testCaseOfCorrectAggregateCreationWithoutAssigningAccount(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID, 'role' => Role::MANAGER]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, $body = [
            'name' => 'example'
        ]);

        $this->assertResponseStatusCodeSame(self::CREATED);
        $this->assertResponseJsonContent('{"status":201,"message":null}', $this->client);
        $this->assertInDatabase(Aggregate::class, $body);
    }

    public function testCaseOfCorrectAggregateCreationWithAssigningAccount(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID, 'role' => Role::MANAGER]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, [
            'name' => 'example',
            'accountUuids' => ['0053bf63-cc69-48eb-9b1c-09f52185d627']
        ]);

        $this->assertResponseStatusCodeSame(self::CREATED);
        $this->assertResponseJsonContent('{"status":201,"message":null}', $this->client);
    }

    public function testCaseCreatingAggregateForExistingName(): void
    {
        $this->loadFixtures([AggregateData::class => [
            'aggregateUuid' => self::BASE_UUID,
            'accountUuid' => self::BASE_UUID,
            'accountRole' => Role::MANAGER
        ]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, [
            'name' => 'exampleName'
        ]);

        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"name":"This value already exists."}}',
            $this->client
        );
    }
}