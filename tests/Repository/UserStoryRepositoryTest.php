<?php

namespace App\Tests\Repository;

use App\Entity\OrderedStories;
use App\Entity\UserStory;
use App\Repository\UserStoryRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertSame;

class UserStoryRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;
    private UserStoryRepository $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(UserStory::class);
    }

    public function testGetNextStory() {
        $next = $this->repository->getNextStory($this->repository->find(1));
        self::assertSame($next->getId(), 6);
    }

    public function testFindAllBySprint(): void
    {
        $stories = $this->repository->findAllBySprint(1);
        $storiesId = array_map(function (OrderedStories $story) {
            return $story->getId();
        }, $stories);
        assertSame([1,6,2], $storiesId);
    }

    public function testFindAllByBacklog(): void {
        $stories = $this->repository->findAllByBacklog(1);
        $storiesId = array_map(function (OrderedStories $story) {
            return $story->getId();
        }, $stories);
        assertSame([8, 7], $storiesId);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
