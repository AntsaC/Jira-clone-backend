<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class BacklogControllerTest extends ApiTestCase
{
    public function testBacklogByProject(): void
    {
        $response = static::createClient()->request('GET', '/projects/1/backlog');
        $expected = [
            'cards' => [
                [
                    'id' => 6
                ],
                [
                    'id' => 8
                ]
            ]
        ];
        $this->assertResponseIsSuccessful();
        self::assertCount(2, $response->toArray()['cards']);
        self::assertJsonContains($expected);
    }

}
