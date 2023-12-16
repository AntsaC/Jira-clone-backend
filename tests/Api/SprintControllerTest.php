<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class SprintControllerTest extends ApiTestCase
{
    const URL_CURRENT_SPRINT = '/projects/1/current-sprint';

    public function testFindCurrentSprint(): void
    {
        $response = static::createClient()->request('GET', self::URL_CURRENT_SPRINT);
        $expected = [
            "id" => 2,
            "startDate" => '2023-11-20',
            "endDate" => '2023-11-30',

        ];
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($expected);
    }

    public function test_GivenNoCurrentSprint_WhenFindCurrentSprint() {
        static::createClient()->request('GET', '/projects/2/current-sprint');
        $expected = [
            "name" => "PD2 Sprint 1"
        ];
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($expected);
    }

    public function test_CurrentSprintNotStarted_WhenFindCurrentSprint() {
        static::createClient()->request('GET', '/projects/3/current-sprint');
        $expected = [
            "name" => "PD3 Sprint 2"
        ];
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($expected);
    }

    public function test_FindAllSprintByProject() {
        $response = self::createClient()->request('GET','projects/1/sprints');
        $expected = [
            [
                'id' => 1,
                'status' => [
                    'name' => 'complete'
                ]
            ],
            [
                'id' => 2,
                'status' => [
                    'name' => 'current'
                ]
            ],
            [
                'id' => 3,
                'status' => [
                    'name' => 'future'
                ]
            ]
        ];
        self::assertResponseIsSuccessful();
        self::assertCount(3, $response->toArray());
        self::assertJsonContains($expected);
    }

    public function test_CreateNewSprint() {
        self::createClient()->request('POST', 'projects/1/sprints', [
            'json' => [
                'name' => 'New sprint',
                'startDate' => '2023-10-10',
                'endDate' => '2023-10-24'
            ]
        ]);
        self::assertResponseStatusCodeSame(201);
    }


}
