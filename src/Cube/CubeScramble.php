<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;
use RobinIngelbrecht\CubeScramble\Scramble;

class CubeScramble implements Scramble, \Stringable
{
    private const REGEX = "/^(?<slices>[2-9]+)?(?<move>[UuFfRrDdLlBbMESxyz])(?<outerBlockIndicator>w)?(?<turnType>\d+\\'|\\'\d+|\d+|\\')?$/";

    /** @var \RobinIngelbrecht\CubeScramble\Cube\Turn[] */
    private array $turns;

    private function __construct(
        Turn ...$turns
    ) {
        $this->turns = $turns;
    }

    public function fromNotationAndSize(string $notation, Size $size): Scramble
    {
        $turns = [];
        foreach (explode(' ', $notation) as $turn) {
            if (!preg_match(self::REGEX, $notation, $matches)) {
                throw new InvalidScramble(sprintf('Invalid turn "%s", valid turns are %s', $turn, implode(', ', Move::casesAsStrings())));
            }

            $move = $matches['move'];
            $isLowerCaseMove = $move === strtolower($move) && !in_array($move, ['x', 'y', 'z']);
            if ($isLowerCaseMove) {
                $move = strtoupper($move);
            }

            $outerBlockIndicator = $matches['outerBlockIndicator'] ?? '';
            $slices = $matches['slices'] ?? null;
            if (!$outerBlockIndicator && $slices) {
                throw new InvalidScramble(sprintf('Invalid turn "%s", cannot specify number of slices if outer block move indicator "w" is not present', $turn));
            }

            if ($outerBlockIndicator && !$slices) {
                $slices = 2;
            }

            $slices = $slices ?? 1;

            $maxAllowedSlice = floor($size->getValue() / 2);
            if ($slices > $maxAllowedSlice) {
                throw new InvalidScramble(sprintf('Invalid turn "%s", slice cannot be greater than %s', $turn, $maxAllowedSlice));
            }

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $notation,
                Move::from($move),
                TurnType::getByTurnNotation($matches['turnType'] ?? ''),
                $isLowerCaseMove ? 2 : (int) $slices,
            );
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
}
