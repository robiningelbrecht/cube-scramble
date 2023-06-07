<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Turn;

interface TurnType
{
    public function getOpposite(): self;

    public function getModifier(): string;

    public function forHumans(): ?string;

    public static function getByTurnByModifier(string $modifier): self;
}
