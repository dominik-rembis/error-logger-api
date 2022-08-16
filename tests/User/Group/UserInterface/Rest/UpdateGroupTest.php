<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Account\Infrastructure\Fixture\AccountData;
use User\Group\Domain\Entity\UserGroup;
use User\Group\Infrastructure\Fixture\Group;

final class UpdateGroupTest extends BaseWebTestCase
{
    private const BASE_UUID = '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';
    private const SECOND_UUID = '0266e820-82fa-4274-91fd-57281f45b87f';
    private const THIRD_UUID = '0053bf63-cc69-48eb-9b1c-09f52185d627';

    private const ENDPOINT_PATH = '/user/group/' . self::BASE_UUID;

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfCorrectGroupNameChange(): void
    {
        $this->loadFixtures([Group::class => ['groupUuid' => self::BASE_UUID]]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, $body = [
            'name' => 'exampleName2'
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
        $this->assertInDatabase(UserGroup::class, $body);
    }

    public function testCaseOfChangingGroupNameToExistingOne(): void
    {
        $this->loadFixtures([Group::class => ['groupUuid' => self::BASE_UUID]]);
        $this->loadFixtures([Group::class => [
            'groupUuid' => self::SECOND_UUID,
            'groupName' => 'exampleName2',
            'userEmail' => 'example2@mail.com'
        ]]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, [
            'name' => 'exampleName2'
        ]);

        $this->assertResponseStatusCodeSame(self::UNPROCESSABLE_ENTITY);
        $this->assertResponseJsonContent(
            '{"status":422,"validation":{"name":"This value already exists."}}',
            $this->client
        );
        $this->assertNotInDatabase(UserGroup::class, [
            'uuid' => self::BASE_UUID,
            'name' => 'exampleName2'
        ]);
    }

    public function testCaseOfAssigningNewUserToGroup(): void
    {
        $this->loadFixtures([
            Group::class => ['groupUuid' => self::BASE_UUID, 'userUuid' => self::SECOND_UUID],
            AccountData::class => ['uuid' => self::THIRD_UUID, 'email' => 'example2@mail.com']
        ]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, [
            'name' => 'example',
            'userUuids' => [self::SECOND_UUID, self::THIRD_UUID]
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
    }

    public function testCaseOfRemovingUserFromGroup(): void
    {
        $this->loadFixtures([
            Group::class => ['groupUuid' => self::BASE_UUID, 'userUuid' => self::SECOND_UUID]
        ]);

        $this->client->jsonRequest(self::PUT, self::ENDPOINT_PATH, [
            'name' => 'example',
            'userUuids' => []
        ]);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"message":null}', $this->client);
    }
}