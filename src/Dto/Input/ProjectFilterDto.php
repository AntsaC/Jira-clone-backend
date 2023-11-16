<?php

namespace App\Dto\Input;

class ProjectFilterDto
{
    public function __construct(
        public readonly int $page = 0
    )
    {
    }
}