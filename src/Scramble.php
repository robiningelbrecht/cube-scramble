<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface Scramble extends \Stringable, \JsonSerializable
{
    public function forHumans(): string;

    public function reverse(): self;

    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn[]
     */
    public function getTurns(): array;

    public static function random(int $scrambleSize): self;

    public static function fromNotation(string $notation): self;
}
