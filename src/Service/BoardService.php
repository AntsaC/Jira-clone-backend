<?php

namespace App\Service;

use App\Dto\output\Board;
use App\Entity\StoryStatus;
use App\Entity\UserStory;
use App\Repository\StoryStatusRepository;
use App\Repository\UserStoryRepository;
use Doctrine\Common\Collections\ArrayCollection;

class BoardService
{
    public function __construct(
        private  readonly UserStoryRepository $userStoryRepository,
        private readonly StoryStatusRepository $statusRepository
    )
    {
    }

    public function createBoardBySprint($sprint): Board
    {
        $board = new Board();
        $stories = $this->userStoryRepository->findAllBySprint($sprint);
        $status = $this->statusRepository->findAll();
        foreach ($status as $s) {
            $this->findStoriesByStatus($s, $stories);
        }
        $board->setColumns($status);
        return $board;
    }

    private function findStoriesByStatus(StoryStatus $status,ArrayCollection $stories): void
    {
        $filteredStories = $stories
            ->filter(function (UserStory $story) use ($status) { return $story->getStatus()->getId() === $status->getId(); });
        foreach ($filteredStories as $story) {
            $status->getCards()->add($story);
        }
    }

}