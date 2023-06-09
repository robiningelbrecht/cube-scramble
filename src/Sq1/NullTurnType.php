<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Sq1;

use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\TurnType as TurnTypeBase;

class NullTurnType implements TurnTypeBase, \JsonSerializable
{
    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function getOpposite(): self
    {
        throw new NotImplemented();
    }

    public function getModifier(): string
    {
        throw new NotImplemented();
    }

    public function forHumans(): ?string
    {
        throw new NotImplemented();
    }

    public static function getByTurnByModifier(string $modifier): self
    {
        throw new NotImplemented();
    }

    public function jsonSerialize(): ?string
    {
        return null;
    }
}
