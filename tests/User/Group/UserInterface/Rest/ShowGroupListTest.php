<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Group\Infrastructure\Fixture\Group;

final class ShowGroupListTest extends BaseWebTestCase
{
    private const ENDPOINT_PATH = '/user/group';

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfUserGroupListWasNotFound(): void
    {
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"data":[]}', $this->client);
    }

    public function testCaseForFindingUserGroupsList(): void
    {
        $this->loadFixtures([Group::class => ['groupUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba']]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","userCount":1}]}',
            $this->client
        );
    }

    public function testCaseOfFindingGroupListWhenUserHasBeenInactive(): void
    {
        $this->loadFixtures([Group::class => [
            'groupUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba',
            'userIsActive' => false
        ]]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":[{"uuid":"6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba","name":"exampleName","userCount":0}]}',
            $this->client
        );
    }
}