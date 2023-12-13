<?php

namespace App\Tests\Repository;

use App\Dto\Input\PartialStory;
use App\Entity\OrderedStories;
use App\Entity\Sprint;
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

    public function testReorder_WhenLiftUp() {
        $newStory = $this->nextStoryFixture(2);

        $this->repository->reorder(6, $this->repository->find(2));

        $stories = array_map(function ($story) {
            return $story->getId();
        }, $this->repository->findAllBySprint(1));

        self::assertEquals([1,2,6,$newStory->getId()], $stories);
    }

    public function testReorder_WhenLiftDown() {
        $newStory = $this->nextStoryFixture(2);

        $this->repository->reorder($newStory->getId(), $this->repository->find(6));

        $stories = array_map(function ($story) {
            return $story->getId();
        }, $this->repository->findAllBySprint(1));

        self::assertEquals([1,2,6,$newStory->getId()], $stories);
    }

    public function testReorder_WhenLiftToFirstPosition() {

        $this->repository->reorder(1, $this->repository->find(2));

        $stories = array_map(function ($story) {
            return $story->getId();
        }, $this->repository->findAllBySprint(1));

        self::assertEquals([2,1,6], $stories);
    }

    public function testReorder_WhenLiftToLastPosition() {

        $this->repository->reorder(2, $this->repository->find(1), true);

        $stories = array_map(function ($story) {
            return $story->getId();
        }, $this->repository->findAllBySprint(1));

        self::assertEquals([6,2,1], $stories);
    }

    public function testFindAllBySprint(): void
    {
        $stories = $this->repository->findAllBySprint(1);
        $storiesId = array_map(function (UserStory $story) {
            return [$story->getId(), $story->getStatus()->getName()] ;
        }, $stories);
        assertSame([[1,'DONE'],[6,'DONE'],[2,'TODO']], $storiesId);
    }

    public function testFindAllByBacklog(): void {
        $stories = $this->repository->findAllByBacklog(1);
        $storiesId = array_map(function (UserStory $story) {
            return $story->getId();
        }, $stories);
        assertSame([8, 7], $storiesId);
    }

    public function testComputeStoryPointGroupByStatus_GivenStoryIsInBacklog(): void {
        $actual = $this->repository->computeStoryPointGroupByStatus(1);
        self::assertEquals(0, $actual->done);
        self::assertEquals(6, $actual->in_progress);
        self::assertEquals(6, $actual->todo);
    }

    public function testComputeStoryPointGroupByStatus_GivenStoryIsInSprint1(): void {
        $actual = $this->repository->computeStoryPointGroupByStatus(1, isInBacklog: false);
        self::assertEquals(8, $actual->done);
        self::assertEquals(0, $actual->in_progress);
        self::assertEquals(2, $actual->todo);
    }
    
    public function testPartialUpdate_GivenPropertyIsSummary(): void {
        $story = new PartialStory('summary','Updated summary value');
        $currentStory = $this->repository->partialUpdate(1, $story);
        self::assertEquals($story->value, $currentStory->getSummary());
    }

    public function testPartialUpdate_GivenPropertyIsPoint(): void {
        $story = new PartialStory('storyPoint',25);
        $currentStory = $this->repository->partialUpdate(1, $story);
        self::assertEquals($story->value, $currentStory->getStoryPoint());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    private function nextStoryFixture(int $previousStoryId): UserStory {
        $newStory = new UserStory();
        $newStory->setSummary("");
        $newStory->setPrevious($this->entityManager->getReference(UserStory::class, $previousStoryId));
        $newStory->setSprint($this->entityManager->getReference(Sprint::class, 1));
        $this->repository->persist(1, $newStory);
        return $newStory;
    }
}
