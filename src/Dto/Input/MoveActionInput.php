<?php

namespace App\Dto\Input;

class MoveActionInput
{

    public function __construct(
        public readonly array $stories,
        public readonly ?int $sprint = null
    )
    {
    }
}