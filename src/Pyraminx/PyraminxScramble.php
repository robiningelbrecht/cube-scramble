<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\SimpleScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\SimpleTurnType;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class PyraminxScramble implements Scramble
{
    private const REGEX = "/^(?<move>[UuRrLlBb])(?<turnType>\\')?$/";

    private function __construct(
        private readonly Scramble $scramble,
    ) {
    }

    public static function random(int $scrambleSize): Scramble
    {
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

        $cornerMoves = Move::cornerMoves();
        shuffle($cornerMoves);
        for ($i = 0; $i < rand(1, 4); ++$i) {
            $move = $cornerMoves[$i];
            $turnType = SimpleTurnType::random();
            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $move->value.$turnType->getModifier(),
                $move,
                $turnType,
                1,
                new ForHumans(),
            );
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
                $move === strtoupper($move) ? 2 : 1,
                new ForHumans(),
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
