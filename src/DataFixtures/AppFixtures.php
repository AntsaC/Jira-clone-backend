<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(private  readonly Connection $connection)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $data = file_get_contents("data.sql");
        $this->connection->getNativeConnection()->exec($data);
    }
}
