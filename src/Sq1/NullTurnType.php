<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Sq1;

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
        throw new \RuntimeException('Not supported');
    }

    public function getModifier(): string
    {
        throw new \RuntimeException('Not supported');
    }

    public function forHumans(): ?string
    {
        throw new \RuntimeException('Not supported');
    }

    public static function getByTurnByModifier(string $modifier): self
    {
        throw new \RuntimeException('Not supported');
    }

    public function jsonSerialize(): ?string
    {
        return null;
    }
}
