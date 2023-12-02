<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserStoryControllerTest extends ApiTestCase
{
    public function testGivenProjectIdIs1_WhenAddUserStoryToBacklog(): void
    {
        $response = static::createClient()->request('POST', '/projects/1/backlog/user-stories', [
            'json' => [
                'summary' => 'My new user story'
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
    }
}
