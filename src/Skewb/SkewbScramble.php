<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Skewb;

use RobinIngelbrecht\TwistyPuzzleScrambler\FromNotation;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Randomizable;
use RobinIngelbrecht\TwistyPuzzleScrambler\Reversible;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\SimpleScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\SimpleTurnType;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class SkewbScramble implements Scramble, Reversible, Randomizable, FromNotation
{
    private const REGEX = "/^(?<move>[URLB])(?<turnType>\\')?$/";

    private function __construct(
        private readonly Scramble $scramble,
    ) {
    }

    public static function random(int $scrambleSize = null): Scramble
    {
        if (!$scrambleSize) {
            throw new InvalidScramble('ScrambleSize is required');
        }
        $turns = [];
        $previousMove = null;

        for ($i = 0; $i < $scrambleSize; ++$i) {
            do {
                $newMove = Move::random();
            } while ($previousMove && $previousMove === $newMove);

            $turnType = SimpleTurnType::random();

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $newMove->value.$turnType->getModifier(),
                $newMove,
                $turnType,
                2,
                new ForHumans()
            );

            $previousMove = $newMove;
        }

        return new self(new SimpleScramble(...$turns));
    }

    public static function fromNotation(string $notation): Scramble
    {
        $turns = [];
        foreach (explode(' ', $notation) as $turn) {
            if (!preg_match(self::REGEX, $turn, $matches)) {
                throw new InvalidScramble(sprintf('Invalid turn "%s"', $turn));
            }

            $move = $matches['move'];

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $turn,
                Move::from($move),
                SimpleTurnType::getByTurnByModifier($matches['turnType'] ?? ''),
                2,
                new ForHumans()
            );
        }

        return new self(new SimpleScramble(...$turns));
    }

    public function getTurns(): array
    {
        return $this->scramble->getTurns();
    }

    public function reverse(): Scramble
    {
        return new self(
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
        return $this->scramble->jsonSerialize();
    }
}
