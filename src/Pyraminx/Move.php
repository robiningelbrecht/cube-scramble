<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Move as MoveBase;

enum Move: string implements MoveBase
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

    public function forHumans(): string
    {
        return match ($this) {
            self::L, self::l => 'left',
            self::R, self::r => 'right',
            self::U, self::u => 'upper',
            self::B, self::b => 'back',
        };
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
