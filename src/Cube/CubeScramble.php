<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Cube;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class CubeScramble implements Scramble
{
    private const REGEX = "/^(?<slices>[2-9]+)?(?<move>[UFRDLB])(?<outerBlockIndicator>w)?(?<turnType>\d+\\'|\\'\d+|\d+|\\')?$/";

    /** @var \RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn[] */
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
            );
        }

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
            'size' => $this->getSize(),
            'turns' => $this->getTurns(),
        ];
    }
}
