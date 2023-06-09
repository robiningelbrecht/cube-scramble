<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Move as MoveBase;

enum Move: string implements MoveBase
{
    case R = 'R';
    case D = 'D';

    case U = 'U';

    public static function random(): self
    {
        // This method is never used, but the interface requires it.
        throw new NotImplemented();
    }

    public function forHumans(): string
    {
        return match ($this) {
            self::R => 'left',
            self::D, self::U => 'top',
        };
    }
}
