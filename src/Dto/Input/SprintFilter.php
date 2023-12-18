<?php

namespace App\Dto\Input;

class SprintFilter
{
    public function __construct(
        public readonly ?string $status = null,
        public readonly ?string $name = null
    )
    {
    }

}