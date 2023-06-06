<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\Size;
use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\Turn;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\ScrambleTrait;

class PyraminxScramble implements Scramble
{
    use ScrambleTrait;

    /** @var \RobinIngelbrecht\TwistyPuzzleScrambler\Turn[] */
    private array $turns;

    private function __construct(
        Turn ...$turns,
    ) {
        $this->turns = $turns;
    }

    public static function random(int $scrambleSize, Size $size = null): Scramble
    {
        // TODO: Implement random() method.
    }

    public static function fromNotation(string $notation, Size $size = null): Scramble
    {
        // TODO: Implement fromNotation() method.
    }

    public function getTurns(): array
    {
        return $this->turns;
    }

    public function reverse(): Scramble
    {
        $this->turns = $this->reverseTurns();

        return $this;
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
}
