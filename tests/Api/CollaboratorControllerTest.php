<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;

class CollaboratorControllerTest extends ApiTestCase
{
    public function testFindAllCollaboratorByProject(): void
    {
        $response = static::createClient()->request('GET', '/projects/1/collaborators');

        $collaborators = array_column($response->toArray(),'id');

        $this->assertResponseIsSuccessful();
        self::assertEquals([1,2,3,4], $collaborators);
    }

}
