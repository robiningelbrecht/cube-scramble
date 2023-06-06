<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Turn;

interface Move
{
    public static function random(): self;

    public function forHumans(): string;
}
