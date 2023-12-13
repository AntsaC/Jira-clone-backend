<?php

namespace App\Dto\Input;

class PartialStory
{
    public function __construct(
        public readonly string $property,
        public readonly mixed $value
    )
    {
    }

}