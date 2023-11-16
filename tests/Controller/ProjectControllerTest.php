<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProjectControllerTest extends ApiTestCase
{
    public function testFindAll(): void
    {
        static::createClient()->request('GET', '/projects');
        $expected = [
            [
                "name" => "Project 1",
                "type" => [
                    "name" => "Agile project"
                ]
            ],
            [
                "name" => "Project 2",
                "type" => [
                    "name" => "Agile project"
                ]
            ],
            [
                "name" => "Project 3",
                "type" => [
                    "name" => "IT project"
                ]
            ],
            [
                "name" => "Project 4",
                "type" => [
                    "name" => "RH project"
                ]
            ],
            [
                "name" => "Project 5",
                "type" => [
                    "name" => "IT project"
                ]
            ]
        ];
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($expected);
    }

    public function testPagination() {
        $response = self::createClient()->request('GET', 'projects?page=2');
        $expected = [
            [
                "name" => "Project 6"
            ],
            [
                "name" => "Project 7"
            ]
        ];
        $this->assertCount(2, $response->toArray());
        self::assertJsonContains($expected);
    }

}
