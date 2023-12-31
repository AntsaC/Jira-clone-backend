<?php

namespace App\Tests\Repository;

use App\Dto\Input\MoveActionInput;
use App\Dto\Input\PartialStory;
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

    public function testComputeStoryPointByProjectBacklog(): void {
        $actual = $this->repository->computeStoryPointByProjectBacklog(1);
        self::assertContains([
            'status' => 'TODO',
            'point' => 6
        ], $actual);
        self::assertContains([
            'status' => 'IN PROGRESS',
            'point' => 6
        ], $actual);
        self::assertContains([
            'status' => 'DONE',
            'point' => null
        ], $actual);
    }

    public function testComputeStoryPointBySprint(): void {
        $actual = $this->repository->computeStoryPointBySprint(1);
        self::assertContains([
            'status' => 'TODO',
            'point' => 2
        ], $actual);
        self::assertContains([
            'status' => 'IN PROGRESS',
            'point' => null
        ], $actual);
        self::assertContains([
            'status' => 'DONE',
            'point' => 8
        ], $actual);
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

    public function testMoveStoryOnSprint()
    {
        $moveAction = new MoveActionInput([7,8],3);
        $this->repository->moveStory($moveAction);

        $stories = $this->repository->findAllBySprint(3);
        $storiesId = $this->extractStoryId($stories);
        self::assertContains(7, $storiesId);
        self::assertContains(8, $storiesId);
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

    private function extractStoryId($stories)
    {
        return array_map(function ($story){
            return $story->getId();
        }, $stories);
    }
}
