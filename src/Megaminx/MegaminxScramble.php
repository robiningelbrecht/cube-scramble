<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\FromNotation;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Randomizable;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\SimpleScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\SimpleTurnType;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class MegaminxScramble implements Scramble, Randomizable, FromNotation
{
    private const REGEX_D_R = "/^(?<move>[RD])(?<turnType>--|\+\+)$/";
    private const REGEX_U = "/^(?<move>[U])(?<turnType>\\')?$/";

    private function __construct(
        private readonly Scramble $scramble,
    ) {
    }

    public static function random(int $scrambleSize = null, int $numberOfSequences = 7): Scramble
    {
        if (!$scrambleSize) {
            throw new InvalidScramble('ScrambleSize is required');
        }
        $turns = [];
        $moves = [Move::R, Move::D];

        for ($i = 0; $i < $numberOfSequences; ++$i) {
            for ($j = 0; $j < $scrambleSize; ++$j) {
                $move = $moves[$j % 2];
                $turnType = TurnType::random();
                $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                    $move->value.$turnType->getModifier(),
                    $move,
                    $turnType,
                    1,
                    new ForHumans()
                );
            }

            $turnType = SimpleTurnType::random();
            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                Move::U->value.$turnType->getModifier(),
                Move::U,
                $turnType,
                1,
                new ForHumans()
            );
        }

        return new self(new SimpleScramble(...$turns));
    }

    public static function fromNotation(string $notation): Scramble
    {
        $turns = [];
        foreach (explode(' ', $notation) as $turn) {
            if (preg_match(self::REGEX_D_R, $turn, $matches)) {
                $move = $matches['move'];

                $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                    $turn,
                    Move::from($move),
                    TurnType::getByTurnByModifier($matches['turnType'] ?? ''),
                    1,
                    new ForHumans(),
                );
                continue;
            }
            if (preg_match(self::REGEX_U, $turn, $matches)) {
                $move = $matches['move'];

                $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                    $turn,
                    Move::from($move),
                    SimpleTurnType::getByTurnByModifier($matches['turnType'] ?? ''),
                    1,
                    new ForHumans(),
                );
                continue;
            }

            throw new InvalidScramble(sprintf('Invalid turn "%s"', $turn));
        }

        return new self(new SimpleScramble(...$turns));
    }

    public function getTurns(): array
    {
        return $this->scramble->getTurns();
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
