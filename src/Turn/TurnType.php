<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Turn;

interface TurnType
{
    public function getOpposite(): self;

    public function getDegrees(): int;

    public function getModifier(): string;

    public function forHumans(): ?string;
}
