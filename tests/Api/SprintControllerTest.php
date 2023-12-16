<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class SprintControllerTest extends ApiTestCase
{
    const URL_CURRENT_SPRINT = '/projects/1/current-sprint';

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
        dd($response->toArray());
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
