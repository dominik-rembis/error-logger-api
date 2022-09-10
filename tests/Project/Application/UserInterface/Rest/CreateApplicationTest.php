<?php

declare(strict_types=1);

namespace Project\Application\UserInterface\Rest;

use Project\Application\Domain\Entity\Application;
use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\ObjectValue\Role;
use User\Account\Infrastructure\Fixture\AccountData;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class CreateApplicationTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const SECOND_UUID = 'b4a018b2-0b31-4212-8376-3a9acca45495';

    private const ENDPOINT_PATH = '/project/application';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfCorrectApplicationCreation(): void
    {
        $this->loadFixtures([AggregateData::class => [
            'aggregateUuid' => self::BASE_UUID,
            'accountUuid' => self::SECOND_UUID,
            'accountRole' => Role::MANAGER
        ]]);

        $this->loginUser(['uuid' => self::SECOND_UUID], $this->client);
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, $body = [
            'name' => 'example name',
            'aggregateUuid' => self::BASE_UUID
        ]);

        $this->assertResponseStatusCodeSame(self::CREATED);
        $this->assertResponseJsonContent('{"status":201,"message":null}', $this->client);
        $this->assertInDatabase(Application::class, $body);
    }

    public function testCaseOfAssignmentApplicationToNonexistentAggregate(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID, 'role' => Role::MANAGER]]);

        $this->loginUser(['uuid' => self::BASE_UUID], $this->client);
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, [
            'name' => 'example name',
            'aggregateUuid' => self::SECOND_UUID
        ]);

        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"aggregateUuid":"This value not exists."}}',
            $this->client
        );
    }

    public function testCaseForNoAuthentication(): void
    {
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, [
            'name' => 'example name',
            'aggregateUuid' => self::BASE_UUID
        ]);

        $this->assertResponseStatusCodeSame(self::UNAUTHORIZED);
    }
}