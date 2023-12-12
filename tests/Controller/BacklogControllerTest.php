<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class BacklogControllerTest extends ApiTestCase
{

    public function testGetBacklogByProject()
    {
        $response = $this->createClient()->request('GET', 'projects/1/backlog');
        self::assertResponseIsSuccessful();
        self::assertCount(2, $response->toArray()['cards']);
    }
}
