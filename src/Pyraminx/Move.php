<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx;

enum Move: string
{
    case U = 'U';
    case R = 'R';
    case L = 'L';
    case B = 'B';

    case u = 'u';
    case l = 'l';
    case r = 'r';
    case b = 'b';

    public static function random(): self
    {
        $moves = [
            self::U,
            self::R,
            self::L,
            self::B,
        ];

        return $moves[array_rand($moves)];
    }

    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx\Move[]
     */
    public static function wideMoves(): array
    {
        return [
            self::u,
            self::l,
            self::r,
            self::b,
        ];
    }
}
