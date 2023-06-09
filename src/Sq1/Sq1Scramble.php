<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Sq1;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\SimpleScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class Sq1Scramble implements Scramble
{
    private const REGEX = "/^\((?<topMove>-?[\d]),(?<bottomMove>-?[\d])\)\/$/";

    private function __construct(
        private readonly Scramble $scramble,
    ) {
    }

    public static function random(int $scrambleSize): Scramble
    {
        $sq1 = Sq1::create();
        $turns = [];
        for ($i = 0; $i < $scrambleSize; ++$i) {
            $possibleTopMoves = $sq1->getPossibleTopMoves();
            $possibleBottomMoves = $sq1->getPossibleBottomMoves();

            do {
                $topMove = $possibleTopMoves[array_rand($possibleTopMoves)];
                $bottomMove = $possibleBottomMoves[array_rand($possibleBottomMoves)];
            } while (0 === $topMove && 0 === $bottomMove);

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                sprintf('(%d,%d)/', $topMove, $bottomMove),
                Move::fromTopAndBottomMoves($topMove, $bottomMove),
                NullTurnType::create(),
                1,
                new ForHumans()
            );

            $sq1->turnTop($topMove);
            $sq1->turnBottom($bottomMove);
            $sq1->slice();
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

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $turn,
                Move::fromTopAndBottomMoves((int) $matches['topMove'], (int) $matches['bottomMove']),
                NullTurnType::create(),
                1,
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
        return new self($this->scramble->reverse());
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
