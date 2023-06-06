<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface Move
{
    public static function random(): self;

    public function forHumans(): string;
}
