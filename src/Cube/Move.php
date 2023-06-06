<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Cube;

use RobinIngelbrecht\TwistyPuzzleScrambler\Move as MoveBase;

enum Move: string implements MoveBase
{
    case U = 'U';
    case R = 'R';
    case F = 'F';
    case D = 'D';
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
            self::L => 'left',
            self::R => 'right',
            self::U => 'upper',
            self::D => 'bottom',
            self::F => 'front',
            self::B => 'back',
        };
    }

    public function getPlane(): Plane
    {
        return match ($this) {
            self::L, self::R => Plane::x,
            self::U, self::D => Plane::y,
            self::F, self::B => Plane::z,
        };
    }
}
