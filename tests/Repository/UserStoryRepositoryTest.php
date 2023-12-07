<?php

namespace App\Tests\Repository;

use App\Entity\UserStory;
use App\Repository\UserStoryRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserStoryRepositoryTest extends KernelTestCase
{
    private EntityManager $entityManager;
    private UserStoryRepository $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(UserStory::class);
    }


    public function testFindAllBySprint(): void
    {
        $stories = $this->repository->findAllBySprint(1);

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
