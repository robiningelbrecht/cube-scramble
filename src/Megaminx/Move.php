<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Move as MoveBase;

enum Move: string implements MoveBase
{
    case R = 'R';
    case D = 'D';

    case U = 'U';

    public static function random(): self
    {
        $moves = [
            self::R,
            self::D,
        ];

        return $moves[array_rand($moves)];
    }

    public function forHumans(): string
    {
        return match ($this) {
            self::R => 'left',
            self::D, self::U => 'top',
        };
    }
}
