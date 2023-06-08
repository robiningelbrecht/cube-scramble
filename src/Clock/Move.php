<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Clock;

use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Move as MoveBase;

enum Move: string implements MoveBase
{
    case UR = 'UR';
    case DR = 'DR';
    case DL = 'DL';
    case UL = 'UL';
    case U = 'U';
    case R = 'R';
    case D = 'D';
    case L = 'L';
    case ALL = 'ALL';
    case y = 'y';

    public static function random(): self
    {
        // This method is never used, but the interface requires it.
        throw new \RuntimeException('Not supported');
    }

    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Clock\Move[]
     */
    public static function endMoves(): array
    {
        return [
            self::UR,
            self::DR,
            self::DL,
            self::UL,
        ];
    }

    public function forHumans(): string
    {
        return 'todo';
    }
}
