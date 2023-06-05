<?php

namespace RobinIngelbrecht\CubeScramble;

use RobinIngelbrecht\CubeScramble\Cube\Size;

interface Scramble
{
    public function forHumans(): string;

    public function reverse(): self;

    public static function random(int $scrambleSize, Size $size = null): self;

    public static function fromNotation(string $notation, Size $size = null): self;
}
