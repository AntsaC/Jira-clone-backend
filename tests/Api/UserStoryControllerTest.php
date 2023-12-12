<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserStoryControllerTest extends ApiTestCase
{
    public function testFindAllBySprint() {
        $response = self::createClient()->request('GET', 'sprints/1/stories');
        self::assertResponseIsSuccessful();
        self::assertCount(3, $response->toArray());
    }

    public function testGivenProjectIdIs1_WhenAddUserStoryToBacklog(): void
    {
        $response = static::createClient()->request('POST', '/projects/1/user-stories', [
            'json' => [
                'summary' => 'My new user story'
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testGivenProjectIdIs1_WhenAddUserStoryToSprint1(): void
    {
        $response = static::createClient()->request('POST', '/projects/1/user-stories', [
            'json' => [
                'summary' => 'My user story for sprint 1',
                'sprint' => [
                    'id' => 1
                ]
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);
    }

    public function testFindById() {
        static::createClient()->request('GET', '/projects/1/user-stories/1');
        $expected = [
            'id' => 1,
            'sprint' => [
                'id' => 1
            ]
        ];
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($expected);
    }

    public function testGivenProjectIdIs1_WhenUpdateUserStory(): void
    {
        $response = static::createClient()->request('PUT', '/projects/1/user-stories/1', [
            'json' => [
                'summary' => 'Updated user story'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(
            [
                'summary' => 'Updated user story'
            ]
        );
    }

    public function testDelete() {
        self::createClient()->request('DELETE', '/projects/1/user-stories/3');
        self::assertResponseStatusCodeSame(204);
    }

    public function testEnterUserStoryToSprint() {
        self::createClient()->request('PUT', 'projects/1/user-stories/4', [
           'json' => [
               'summary' => 'User',
               'sprint' => [
                   'id' => 4
               ]
           ]
        ]);
        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            'sprint' => [
                'id' => 4
            ]
        ]);
    }

}
