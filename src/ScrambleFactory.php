<?php

namespace RobinIngelbrecht\CubeScramble;

use RobinIngelbrecht\CubeScramble\Cube\CubeScramble;
use RobinIngelbrecht\CubeScramble\Cube\Size;

class ScrambleFactory
{
    public static function twoByTwo(string $notation): Scramble
    {
        return CubeScramble::fromNotation($notation, Size::fromInt(2));
    }

    public static function threeByThree(string $notation): Scramble
    {
        return CubeScramble::fromNotation($notation, Size::fromInt(3));
    }

    public static function fourByFour(string $notation): Scramble
    {
        return CubeScramble::fromNotation($notation, Size::fromInt(4));
    }

    public static function fiveByFive(string $notation): Scramble
    {
        return CubeScramble::fromNotation($notation, Size::fromInt(5));
    }

    public static function sixBySix(string $notation): Scramble
    {
        return CubeScramble::fromNotation($notation, Size::fromInt(6));
    }

    public static function sevenBySeven(string $notation): Scramble
    {
        return CubeScramble::fromNotation($notation, Size::fromInt(7));
    }
}
