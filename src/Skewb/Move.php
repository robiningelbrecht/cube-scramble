<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Skewb;

use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Move as MoveBase;

enum Move: string implements MoveBase
{
    case U = 'U';
    case R = 'R';
    case L = 'L';
    case B = 'B';

    public static function random(): self
    {
        $moves = self::cases();

        return $moves[array_rand($moves)];
    }

    public function forHumans(): string
    {
        return match ($this) {
            self::L, => 'left',
            self::R => 'right',
            self::U => 'upper',
            self::B => 'back',
        };
    }
}
