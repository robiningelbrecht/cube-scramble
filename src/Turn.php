<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface Turn extends \JsonSerializable
{
    public function getOpposite(): self;

    public function getNotation(): string;

    public function forHumans(): string;
}
