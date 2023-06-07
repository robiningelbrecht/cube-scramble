<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\SimpleTurnType;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class MegaminxScramble extends Scramble
{
    private const REGEX_D_R = "/^(?<move>[RD])(?<turnType>--|\+\+)$/";
    private const REGEX_U = "/^(?<move>[U])(?<turnType>\\')?$/";

    public static function random(int $scrambleSize, int $numberOfSequences = 7): Scramble
    {
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

        return new self(...$turns);
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

        return new self(...$turns);
    }
}
