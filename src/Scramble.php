<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface Scramble extends \Stringable, \JsonSerializable
{
    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn[]
     */
    public function getTurns(): array;

    public function reverse(): self;

    public function forHumans(): string;

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array;
}
