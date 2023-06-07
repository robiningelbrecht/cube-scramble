<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\CubeScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\Size;
use RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx\PyraminxScramble;

class RandomScramble
{
    public static function twoByTwo(): Scramble
    {
        return CubeScramble::random(9, Size::fromInt(2));
    }

    public static function threeByThree(): Scramble
    {
        return CubeScramble::random(20, Size::fromInt(3));
    }

    public static function fourByFour(): Scramble
    {
        return CubeScramble::random(44, Size::fromInt(4));
    }

    public static function fiveByFive(): Scramble
    {
        return CubeScramble::random(60, Size::fromInt(5));
    }

    public static function sixBySix(): Scramble
    {
        return CubeScramble::random(80, Size::fromInt(6));
    }

    public static function sevenBySeven(): Scramble
    {
        return CubeScramble::random(100, Size::fromInt(7));
    }

    public static function pyraminx(): Scramble
    {
        return PyraminxScramble::random(8);
    }
}
