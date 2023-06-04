<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;

enum TurnType: string
{
    case CLOCKWISE = 'clockwise';
    case COUNTER_CLOCKWISE = 'counterClockwise';
    case DOUBLE = 'double';
    case NONE = 'none';

    public function getOpposite(): self
    {
        return match ($this) {
            self::CLOCKWISE => self::COUNTER_CLOCKWISE,
            self::COUNTER_CLOCKWISE => self::CLOCKWISE,
            default => $this,
        };
    }

    public static function getByTurnNotation(string $turnAbbreviation): self
    {
        switch ($turnAbbreviation) {
            case '':
                return self::CLOCKWISE;
            case "'":
                return self::COUNTER_CLOCKWISE;
            case '2':
            case "2'":
            case "'2":
                return self::DOUBLE;
            default: throw new InvalidScramble(sprintf('Invalid turnAbbreviation "%s"', $turnAbbreviation));
        }
    }
}
