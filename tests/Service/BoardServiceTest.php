<?php

namespace App\Tests\Service;

use App\Entity\StoryStatus;
use App\Entity\UserStory;
use App\Repository\StoryStatusRepository;
use App\Repository\UserStoryRepository;
use App\Service\BoardService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class BoardServiceTest extends TestCase
{
    private BoardService $service;

    protected function setUp(): void
    {
        $userStoryRepository = $this->createMock(UserStoryRepository::class);
        $userStoryRepository->expects(self::any())
            ->method('findAllBySprint')
            ->willReturn($this->loadStories());

        $statusRepository = $this->createMock(StoryStatusRepository::class);
        $statusRepository->expects(self::any())
            ->method('findAll')
            ->willReturn(new ArrayCollection([
                StoryStatus::createById(1),
                StoryStatus::createById(2),
                StoryStatus::createById(3)
            ]));

        $this->service = new BoardService($userStoryRepository, $statusRepository);
    }

    private function loadStories(): ArrayCollection
    {
        $stories = new ArrayCollection();

        $createStory = function ($id, $status) {
            $story = new UserStory();
            $story->setId($id);
            $story->setStatus(StoryStatus::createById($status));
            return $story;
        };

        $stories->add($createStory(1, 1));
        $stories->add($createStory(2, 2));
        $stories->add($createStory(3, 1));
        $stories->add($createStory(4, 3));
        $stories->add($createStory(5, 2));

        return $stories;
    }

    public function testCreateBoardBySprint(): void
    {
        $board = $this->service->createBoardBySprint(1);
        self::assertCount(3, $board->getColumns());

        $this->assertStatusCard([1,3], $board->getColumns()->get(0));
        $this->assertStatusCard([2,5], $board->getColumns()->get(1));
        $this->assertStatusCard([4], $board->getColumns()->get(2));
    }

    private function assertStatusCard($expectedCard, StoryStatus $status): void
    {
        $cards = array_map(function (UserStory $story) {
            return $story->getId();
        }, $status->getCards()->toArray());

        self::assertEquals($expectedCard, $cards);
    }
}
