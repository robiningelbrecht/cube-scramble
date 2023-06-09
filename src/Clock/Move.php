<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Clock;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;
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
        throw new NotImplemented();
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

    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Clock\Move[]
     */
    public static function bothMoves(): array
    {
        return [
            self::U,
            self::R,
            self::D,
            self::L,
        ];
    }

    public function forHumans(): string
    {
        return match ($this) {
            self::UR => 'up-right',
            self::DR => 'down-right',
            self::DL => 'down-left',
            self::UL => 'up-left',
            self::U => 'upper',
            self::R => 'right',
            self::D => 'down',
            self::L => 'left',
            self::ALL => 'all',
            default => throw new InvalidScramble(sprintf('Invalid move %s', $this->value))
        };
    }
}
