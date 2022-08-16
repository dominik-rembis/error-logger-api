<?php

declare(strict_types=1);

namespace User\Group\UserInterface\Rest;

use Shared\Infrastructure\Proxy\Test\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use User\Group\Infrastructure\Fixture\Group;

final class ShowGroupDataTest extends BaseWebTestCase
{
    private const ENDPOINT_PATH = '/user/group/6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba';

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    public function testCaseOfNotFindingGroupData(): void
    {
        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::NOT_FOUND);
        $this->assertResponseJsonContent(
            '{"status":404,"message":"The searched value was not found."}',
            $this->client
        );
    }

    public function testCaseOfFindingGroupData(): void
    {
        $this->loadFixtures([Group::class => [
            'groupUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba',
            'userUuid' => '0053bf63-cc69-48eb-9b1c-09f52185d627'
        ]]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent(
            '{"status":200,"data":{"name":"exampleName","users":[{"uuid":"0053bf63-cc69-48eb-9b1c-09f52185d627","name":"exampleName","surname":"exampleSurname"}]}}',
            $this->client
        );
    }

    public function testCaseOfFindingGroupDataWhenUserHasBeenInactive(): void
    {
        $this->loadFixtures([Group::class => [
            'groupUuid' => '6dca9476-1dd2-49ff-8fc3-4cbeed1e02ba',
            'userUuid' => '0053bf63-cc69-48eb-9b1c-09f52185d627',
            'userIsActive' => false
        ]]);

        $this->client->request(self::GET, self::ENDPOINT_PATH);

        $this->assertResponseStatusCodeSame(self::OK);
        $this->assertResponseJsonContent('{"status":200,"data":{"name":"exampleName","users":[]}}', $this->client);
    }
}