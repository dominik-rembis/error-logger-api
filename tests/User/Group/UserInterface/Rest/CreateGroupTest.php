<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Infrastructure\Fixture\AccountData;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Infrastructure\Fixture\Group;

final class CreateGroupTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const ENDPOINT_PATH = '/user/group';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }
    public function testCaseOfCorrectGroupCreationWithoutAssigningUser(): void
    {
        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, $body = [
            'name' => 'example'
        ]);

        $this->assertResponseStatusCodeSame(self::CREATED);
        $this->assertResponseJsonContent('{"status":201,"message":null}', $this->client);
        $this->assertInDatabase(UserGroup::class, $body);
    }

    public function testCaseOfCorrectGroupCreationWithAssigningUser(): void
    {
        $this->loadFixtures([AccountData::class => ['uuid' => self::BASE_UUID]]);

        $this->client->jsonRequest(self::POST, self::ENDPOINT_PATH, [
            'name' => 'example',
            'userUuids' => ['0053bf63-cc69-48eb-9b1c-09f52185d627']
        ]);

        $this->assertResponseStatusCodeSame(self::CREATED);
        $this->assertResponseJsonContent('{"status":201,"message":null}', $this->client);
    }

    public function testCaseCreatingGroupForExistingName(): void
    {
        $this->loadFixtures([Group::class => ['groupUuid' => self::BASE_UUID]]);

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