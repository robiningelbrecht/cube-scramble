<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;
use RobinIngelbrecht\CubeScramble\Scramble;
use RobinIngelbrecht\CubeScramble\ScrambleTrait;

class CubeScramble implements Scramble
{
    use ScrambleTrait;

    /** @var \RobinIngelbrecht\CubeScramble\Turn[] */
    private array $turns;

    private function __construct(
        private readonly Size $size,
        Turn ...$turns,
    ) {
        $this->turns = $turns;
    }

    public static function random(int $scrambleSize, Size $size = null): Scramble
    {
        if (!$size) {
            throw new InvalidScramble('Size is required');
        }

        $turns = [];
        $previousMove = null;

        for ($i = 0; $i < $scrambleSize; ++$i) {
            do {
                $newMove = Move::random();
            } while ($previousMove && $previousMove->getPlane() === $newMove->getPlane());

            $slices = mt_rand(1, $size->getMaxSlices());
            $depthLayer = $slices > 2 ? $slices : '';
            $sliceIndicator = $slices > 1 ? 'w' : '';
            $turnType = TurnType::random();

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $depthLayer.$newMove->value.$sliceIndicator.$turnType->getModifier(),
                $newMove,
                $turnType,
                $slices
            );

            $previousMove = $newMove;
        }

        return new self($size, ...$turns);
    }

    public static function fromNotation(string $notation, Size $size = null): Scramble
    {
        if (!$size) {
            throw new InvalidScramble('Size is required');
        }

        $turns = array_map(
            fn (string $turnNotation) => Turn::fromNotationAndSize($turnNotation, $size),
            explode(' ', $notation)
        );

        return new self($size, ...$turns);
    }

    public function getSize(): Size
    {
        return $this->size;
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
            'size' => $this->getSize(),
            'turns' => $this->getTurns(),
        ];
    }
}
