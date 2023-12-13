<?php

namespace App\Dto\output;

class StoryPointDetailDto
{
    public function __construct(
        public readonly int $todo = 0,
        public readonly int $in_progress = 0,
        public readonly int $done = 0,
    )
    {
    }

    public static function mapFromArray($pointsArray): StoryPointDetailDto
    {
        return new StoryPointDetailDto(
            todo: self::getPointByStatus('TODO', $pointsArray),
            in_progress: self::getPointByStatus('IN PROGRESS', $pointsArray),
            done: self::getPointByStatus('DONE', $pointsArray),
        );
    }

    private static function getPointByStatus($status, $points) : int
    {
        $element = array_filter($points, function ($point) use ($status) {
            return $point['name'] === $status;
        });
        $element = reset($element);
        return empty($element) ? 0 : $element['points'];
    }

}