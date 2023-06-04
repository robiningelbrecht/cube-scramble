<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;
use RobinIngelbrecht\CubeScramble\Scramble;

class CubeScramble implements Scramble, \Stringable, \JsonSerializable
{
    /** @var \RobinIngelbrecht\CubeScramble\Cube\Turn[] */
    private array $turns;

    private function __construct(
        Turn ...$turns
    ) {
        $this->turns = $turns;
    }

    public static function fromNotation(string $notation, Size $size = null): Scramble
    {
        if (!$size) {
            throw new InvalidScramble('Size is required');
        }
        $turns = [];
        foreach (explode(' ', $notation) as $turnNotation) {
            $turns[] = Turn::fromNotationAndSize($turnNotation, $size);
        }

        return new self(...$turns);
    }

    /**
     * @return \RobinIngelbrecht\CubeScramble\Cube\Turn[]
     */
    public function getTurns(): array
    {
        return $this->turns;
    }

    public function reverse(): self
    {
        $this->turns = array_map(
            fn (Turn $turn) => $turn->getOpposite(),
            array_reverse($this->turns)
        );

        return $this;
    }

    public function __toString(): string
    {
        return implode(' ', array_map(fn (Turn $turn) => $turn->getNotation(), $this->getTurns()));
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->getTurns();
    }
}
