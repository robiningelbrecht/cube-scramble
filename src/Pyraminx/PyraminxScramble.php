<?php

namespace RobinIngelbrecht\CubeScramble\Pyraminx;

use RobinIngelbrecht\CubeScramble\Cube\Size;
use RobinIngelbrecht\CubeScramble\Cube\Turn;
use RobinIngelbrecht\CubeScramble\Scramble;
use RobinIngelbrecht\CubeScramble\ScrambleTrait;

class PyraminxScramble implements Scramble
{
    use ScrambleTrait;

    /** @var \RobinIngelbrecht\CubeScramble\Turn[] */
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
