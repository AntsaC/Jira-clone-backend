<?php

namespace App\Dto\output;

class Board
{
    private array $columns;

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

}