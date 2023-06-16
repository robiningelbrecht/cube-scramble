<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface Randomizable
{
    public static function random(): Scramble;
}
