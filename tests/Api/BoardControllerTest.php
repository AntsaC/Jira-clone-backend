<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class BoardControllerTest extends ApiTestCase
{
    public function testBoardBySprint(): void
    {
        $response = static::createClient()->request('GET', '/sprints/1/board');
        self::assertCount(3, $response->toArray()['columns']);
        $this->assertResponseIsSuccessful();
    }
}
