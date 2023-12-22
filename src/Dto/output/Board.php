<?php

namespace App\Dto\output;

use App\Entity\StoryStatus;
use Doctrine\Common\Collections\ArrayCollection;

class Board
{
    private ArrayCollection $columns;

    public function getColumns(): ArrayCollection
    {
        return $this->columns;
    }

    public function setColumns(ArrayCollection $columns): void
    {
        $this->columns = $columns;
    }

}