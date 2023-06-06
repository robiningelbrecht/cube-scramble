<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

trait ScrambleTrait
{
    abstract public function getTurns(): array;

    public function forHumans(): string
    {
        return implode(PHP_EOL, array_map(fn (Turn $turn) => $turn->forHumans(), $this->getTurns()));
    }

    public function __toString(): string
    {
        return implode(' ', array_map(fn (Turn $turn) => $turn->getNotation(), $this->getTurns()));
    }

    /**
     * @return \RobinIngelbrecht\TwistyPuzzleScrambler\Turn[]
     */
    protected function reverseTurns(): array
    {
        return array_map(
            fn (Turn $turn) => $turn->getOpposite(),
            array_reverse($this->getTurns())
        );
    }
}
