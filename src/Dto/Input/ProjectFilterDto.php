<?php

namespace App\Dto\Input;

class ProjectFilterDto
{
    public function __construct(
        public readonly ?string $keyword = null,
        public readonly int $page = 1,
        public readonly ?array $type = null
    )
    {
    }
}