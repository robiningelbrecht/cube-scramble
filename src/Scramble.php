<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

abstract class Scramble implements \Stringable, \JsonSerializable
{
    /** @var \RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn[] */
    private array $turns;

    protected function __construct(
        Turn ...$turns,
    ) {
        $this->turns = $turns;
    }

    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn[]
     */
    public function getTurns(): array
    {
        return $this->turns;
    }

    public function reverse(): Scramble
    {
        $this->turns = array_map(
            fn (Turn $turn) => $turn->getOpposite(),
            array_reverse($this->getTurns())
        );

        return $this;
    }

    public function forHumans(): string
    {
        return implode(PHP_EOL, array_map(fn (Turn $turn) => $turn->forHumans(), $this->getTurns()));
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
        return [
            'turns' => $this->getTurns(),
        ];
    }

    abstract public static function random(int $scrambleSize): self;

    abstract public static function fromNotation(string $notation): self;
}
