<?php

namespace RobinIngelbrecht\CubeScramble;

use RobinIngelbrecht\CubeScramble\Cube\Size;

interface Scramble extends \Stringable, \JsonSerializable
{
    public function forHumans(): string;

    public function reverse(): self;

    /**
     * @return \RobinIngelbrecht\CubeScramble\Turn[]
     */
    public function getTurns(): array;

    public static function random(int $scrambleSize, Size $size = null): self;

    public static function fromNotation(string $notation, Size $size = null): self;
}
