<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CriteriaAcceptanceTest extends ApiTestCase
{
    public function testFindAllByUserStory(): void
    {
        $response = static::createClient()->request('GET', '/user-stories/1/criteria');

        $this->assertResponseIsSuccessful();
        self::assertCount(2, $response->toArray());
        $this->assertJsonContains([
            [
                'criteria' => 'Simple criteria'
            ],
            [
                'criteria' => 'Simple criteria 1'
            ],
        ]);
    }

    public function testCreateCriteria() {
        self::createClient()->request('POST','/user-stories/2/criteria', [
            'json' => [
                'criteria' => 'New criteria'
            ]
        ]);
        self::assertResponseStatusCodeSame(201);
    }

    public function testUpdate()
    {
        self::createClient()->request('PUT', '/user-stories/1/criteria/1', [
            'json' => [
                'criteria' => 'My criteria'
            ]
        ]);
        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            'criteria' => 'My criteria'
        ]);
    }

}
