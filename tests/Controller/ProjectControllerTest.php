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
                ],
                "lead" => [
                    "username" => "john_doe"
                ]
            ],
            [
                "name" => "Project 2",
                "type" => [
                    "name" => "Agile project"
                ],
                "lead" => [
                    "username" => "jane_smith"
                ]
            ],
            [
                "name" => "Project 3",
                "type" => [
                    "name" => "IT project"
                ],
                "lead" => [
                    "username" => "john_doe"
                ]
            ],
            [
                "name" => "Project 4",
                "type" => [
                    "name" => "RH project"
                ],
                "lead" => [
                    "username" => "alice_jones"
                ]
            ],
            [
                "name" => "Project 5",
                "type" => [
                    "name" => "IT project"
                ],
                "lead" => [
                    "username" => "bob_miller"
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
                "name" => "Qice 1"
            ],
            [
                "name" => "Qice 2"
            ]
        ];
        $this->assertCount(2, $response->toArray());
        self::assertJsonContains($expected);
    }

    public function testFindAllProjectThatNameContainIce() {
        $response = self::createClient()->request('GET', 'projects?page=1&keyword=ice');
        $expected = [
            [
                "name" => "Qice 1"
            ],
            [
                "name" => "Qice 2"
            ]
        ];
        $this->assertCount(2, $response->toArray());
        self::assertJsonContains($expected);
    }

    public function testFindAllProjectThatNameContainEAndInPage2() {
        $response = self::createClient()->request('GET', 'projects?page=2&keyword=e');
        $expected = [
            [
                "name" => "Qice 1"
            ],
            [
                "name" => "Qice 2"
            ]
        ];
        $this->assertCount(2, $response->toArray());
        self::assertJsonContains($expected);
    }

    public function testFindAllProjectThatTypeIsAgile() {
        $response = self::createClient()->request('GET', 'projects?page=1&type[]=1');
        $expected = [
            [
                "id" => 1
            ],
            [
                "id" => 2
            ]
        ];
        $this->assertCount(2, $response->toArray());
        self::assertJsonContains($expected);
    }

    public function testFindAllProjectThatTypeIsAgileOrRH() {
        $response = self::createClient()->request('GET', 'projects?page=1&type[]=1&type[]=3');
        $expected = [
            [
                "id" => 1
            ],
            [
                "id" => 2
            ],
            [
                "id" => 4
            ]
        ];
        $this->assertCount(3, $response->toArray());
        self::assertJsonContains($expected);
    }

    public function testCreateNewProject() {
        self::createClient()->request('POST', 'projects', [
            'json' => [
                'name' => 'New project',
                'key' => 'NEW',
                'type' => [
                    'id' => 1
                ]
            ]
        ]);
        self::assertResponseStatusCodeSame(201);
    }

    public function testUpdateProjectWithId1() {
        self::createClient()->request('PUT', 'projects/1', [
            'json' => [
                'name' => 'My project'
            ]
        ]);
        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            'name' => 'My project'
        ]);
    }


}
