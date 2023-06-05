<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;
use RobinIngelbrecht\CubeScramble\Scramble;

class CubeScramble implements Scramble, \JsonSerializable
{
    /** @var \RobinIngelbrecht\CubeScramble\Cube\Turn[] */
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
        $previousFace = null;

        for ($i = 0; $i < $scrambleSize; ++$i) {
            do {
                $newFace = Face::random();
            } while ($previousFace && $previousFace->getPlane() === $newFace->getPlane());

            $slices = mt_rand(1, $size->getMaxSlices());
            $depthLayer = $slices > 2 ? $slices : '';
            $sliceIndicator = $slices > 1 ? 'w' : '';
            $turnType = TurnType::random();

            $turns[] = Turn::fromFaceAndTurnTypeAndSlices(
                $depthLayer.$newFace->value.$sliceIndicator.$turnType->getModifier(),
                $newFace,
                $turnType,
                $slices
            );

            $previousFace = $newFace;
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
            'size' => $this->getSize(),
            'turns' => $this->getTurns(),
        ];
    }
}
