<?php

namespace RobinIngelbrecht\CubeScramble;

use RobinIngelbrecht\CubeScramble\Cube\Size;

interface Scramble
{
    public static function fromNotation(string $notation, Size $size = null): self;

    public function reverse(): self;
}
