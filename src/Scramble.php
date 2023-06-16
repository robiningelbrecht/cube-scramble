<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface Scramble extends HumanReadable, \Stringable, \JsonSerializable
{
    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn[]
     */
    public function getTurns(): array;

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array;
}
