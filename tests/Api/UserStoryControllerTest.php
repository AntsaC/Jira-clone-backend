<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class UserStoryControllerTest extends ApiTestCase
{
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
            ],
            'summary' => 'My first user story'
        ];
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($expected);
    }

}
