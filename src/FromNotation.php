<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface FromNotation
{
    public static function fromNotation(string $notation): Scramble;
}
