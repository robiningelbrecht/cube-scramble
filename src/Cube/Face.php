<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\Plane;

enum Face: string
{
    case U = 'U';
    case R = 'R';
    case F = 'F';
    case D = 'D';
    case L = 'L';
    case B = 'B';

    public static function random(): self
    {
        $faces = Face::cases();

        return $faces[array_rand($faces)];
    }

    public function getPlane(): Plane
    {
        return match ($this) {
            self::L, self::R => Plane::x,
            self::U, self::D => Plane::y,
            self::F, self::B => Plane::z,
        };
    }

    /**
     * @return string[]
     */
    public static function casesAsStrings(): array
    {
        return array_map(fn (Face $face) => $face->value, self::cases());
    }
}
