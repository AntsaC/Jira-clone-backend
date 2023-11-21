<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class SprintControllerTest extends ApiTestCase
{
    const URL_CURRENT_SPRINT = '/projects/1/current-sprint';

    public function testFindCurrentSprint(): void
    {
        static::createClient()->request('GET', self::URL_CURRENT_SPRINT);
        $expected = [
            "id" => 2,
            "startDate" => '2023-11-20',
            "endDate" => '2023-11-30',
            'cards' => [
                [
                    "id" => 3
                ],
                [
                    "id" => 5
                ],
            ]
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
            "name" => "PD2 Sprint 1"
        ];
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($expected);
    }


}
