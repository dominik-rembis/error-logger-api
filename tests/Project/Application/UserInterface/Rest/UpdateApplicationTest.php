<?php

declare(strict_types=1);

namespace Project\Application\UserInterface\Rest;

use Project\Application\Domain\Entity\Application;
use Project\Application\Domain\ObjectValue\AggregateUuid;
use Project\Application\Infrastructure\Fixture\ApplicationData;
use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Domain\ObjectValue\Role;
use User\Aggregate\Infrastructure\Fixture\AggregateData;

final class UpdateApplicationTest extends BaseWebTestCase
{
    private const USER_UUID = '5521b951-4e41-4b1f-9415-6c70106f0062';
    private const AGGREGATE_UUID = 'efc43223-2f50-48c3-a1d0-1a2a3d3c6688';
    private const APPLICATION_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const ENDPOINT = '/project/application/' . self::APPLICATION_UUID;

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfUpdatingApplicationWithTheSameName(): void
    {
        $this->loadFixture();

        $this->loginUser(['uuid' => self::USER_UUID], $this->client);
        $this->client->jsonRequest(self::PUT, self::ENDPOINT, [
            'name' => 'exampleName',
            'aggregateUuid' => self::AGGREGATE_UUID
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
    }

    public function testCaseOfUpdatingApplicationWithTheAnotherName(): void
    {
        $this->loadFixture();

        $this->loginUser(['uuid' => self::USER_UUID], $this->client);
        $this->client->jsonRequest(self::PUT, self::ENDPOINT, $body = [
            'name' => 'anotherName',
            'aggregateUuid' => self::AGGREGATE_UUID
        ]);

        unset($body['aggregateUuid']);
        $this->assertInDatabase(Application::class, $body);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
    }

    public function testCaseOfAssignmentApplicationToNonexistentAggregate(): void
    {
        $this->loadFixture();

        $this->loginUser(['uuid' => self::USER_UUID], $this->client);
        $this->client->jsonRequest(self::PUT, self::ENDPOINT, [
            'name' => 'exampleName',
            'aggregateUuid' => AggregateUuid::generate()
        ]);

        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"aggregateUuid":"This value not exists."}}',
            $this->client
        );
    }

    public function testCaseForNoAuthentication(): void
    {
        $this->client->jsonRequest(self::PUT, self::ENDPOINT, [
            'name' => 'example name',
            'aggregateUuid' => self::AGGREGATE_UUID
        ]);

        $this->assertResponseStatusCodeSame(self::UNAUTHORIZED);
    }

    private function loadFixture(): void
    {
        $this->loadFixtures([
            AggregateData::class => [
                'aggregateUuid' => self::AGGREGATE_UUID,
                'accountUuid' => self::USER_UUID,
                'accountRole' => Role::MANAGER
            ],
            ApplicationData::class => ['applicationUuid' => self::APPLICATION_UUID],
        ]);
    }
}