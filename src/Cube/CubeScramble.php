<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Cube;

use RobinIngelbrecht\TwistyPuzzleScrambler\FromNotation;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Randomizable;
use RobinIngelbrecht\TwistyPuzzleScrambler\Reversible;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\SimpleScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

final class CubeScramble implements Scramble, Reversible, Randomizable, FromNotation
{
    private const REGEX = "/^(?<slices>[2-9]+)?(?<move>[UFRDLB])(?<outerBlockIndicator>w)?(?<turnType>\d+\\'|\\'\d+|\d+|\\')?$/";

    private function __construct(
        private readonly Size $size,
        private readonly Scramble $scramble,
    ) {
    }

    public static function random(int $scrambleSize = null, Size $size = null): Scramble
    {
        if (!$scrambleSize) {
            throw new InvalidScramble('ScrambleSize is required');
        }
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
                $slices,
                new ForHumans(),
            );

            $previousMove = $newMove;
        }

        return new self($size, new SimpleScramble(...$turns));
    }

    public static function fromNotation(string $notation, Size $size = null): Scramble
    {
        if (!$size) {
            throw new InvalidScramble('Size is required');
        }

        $turns = [];
        foreach (explode(' ', $notation) as $turn) {
            if (!preg_match(self::REGEX, $turn, $matches)) {
                throw new InvalidScramble(sprintf('Invalid turn "%s"', $turn));
            }

            $move = $matches['move'];
            $outerBlockIndicator = $matches['outerBlockIndicator'] ?? '';
            $slices = $matches['slices'] ?: null;
            if (!$outerBlockIndicator && $slices) {
                throw new InvalidScramble(sprintf('Invalid turn "%s", cannot specify number of slices if outer block move indicator "w" is not present', $turn));
            }

            if ($outerBlockIndicator && !$slices) {
                $slices = 2;
            }

            $slices = $slices ?? 1;

            if ($slices > $size->getMaxSlices()) {
                throw new InvalidScramble(sprintf('Invalid turn "%s", slice cannot be greater than %s', $turn, $size->getMaxSlices()));
            }

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $turn,
                Move::from($move),
                TurnType::getByTurnByModifier($matches['turnType'] ?? ''),
                $move === strtolower($move) ? 2 : (int) $slices,
                new ForHumans(),
            );
        }

        return new self($size, new SimpleScramble(...$turns));
    }

    public function getSize(): Size
    {
        return $this->size;
    }

    public function getTurns(): array
    {
        return $this->scramble->getTurns();
    }

    public function reverse(): Scramble
    {
        return new self(
            $this->getSize(),
            new SimpleScramble(...array_map(
                fn (Turn $turn) => $turn->getOpposite(),
                array_reverse($this->getTurns())
            ))
        );
    }

    public function forHumans(): string
    {
        return $this->scramble->forHumans();
    }

    public function __toString(): string
    {
        return (string) $this->scramble;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'size' => $this->getSize(),
            ...$this->scramble->jsonSerialize(),
        ];
    }
}
