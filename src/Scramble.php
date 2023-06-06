<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\Size;

interface Scramble extends \Stringable, \JsonSerializable
{
    public function forHumans(): string;

    public function reverse(): self;

    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Turn[]
     */
    public function getTurns(): array;

    public static function random(int $scrambleSize, Size $size = null): self;

    public static function fromNotation(string $notation, Size $size = null): self;
}
