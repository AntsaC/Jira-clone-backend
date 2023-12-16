<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use function Symfony\Component\String\u;

class SprintControllerTest extends ApiTestCase
{
    const URL_CURRENT_SPRINT = '/projects/1/current-sprint';

    public function test_FindAllSprintByProject() {
        $response = self::createClient()->request('GET','projects/1/sprints');
        $expected = [
            [
                'sprint' => ['id' => 1],
            ],
            [
                'sprint' => ['id' => 2],
            ],
            [
                'sprint' => ['id' => 3],
            ],
            [
                'sprint' => ['id' => 6],
            ],
        ];
        self::assertResponseIsSuccessful();
        self::assertCount(4, $response->toArray());
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

    public function test_UpdateSprint() {
        $updatedSprint = [
            'name' => 'New sprint',
            'startDate' => '2023-10-10',
            'endDate' => '2023-10-24'
        ];

        self::createClient()->request('PUT', 'projects/1/sprints/3', [
            'json' => $updatedSprint
        ]);
        self::assertResponseIsSuccessful();
        self::assertJsonContains($updatedSprint);
    }

}
