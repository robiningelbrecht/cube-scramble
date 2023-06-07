<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Scramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class PyraminxScramble implements Scramble
{
    private const REGEX = "/^(?<move>[UuFfRrDdLlBb])?(?<turnType>\\')?$/";

    /** @var \RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn[] */
    private array $turns;

    private function __construct(
        Turn ...$turns,
    ) {
        $this->turns = $turns;
    }

    public static function random(int $scrambleSize): Scramble
    {
        $turns = [];
        $previousMove = null;

        for ($i = 0; $i < $scrambleSize; ++$i) {
            do {
                $newMove = Move::random();
            } while ($previousMove && $previousMove === $newMove);

            $turnType = TurnType::random();

            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $newMove->value.$turnType->getModifier(),
                $newMove,
                $turnType,
                1
            );

            $previousMove = $newMove;
        }

        $wideMoves = Move::wideMoves();
        shuffle($wideMoves);
        for ($i = 0; $i < rand(1, 4); ++$i) {
            $move = $wideMoves[$i];
            $turnType = TurnType::random();
            $turns[] = Turn::fromMoveAndTurnTypeAndSlices(
                $move->value.$turnType->getModifier(),
                $move,
                $turnType,
                2
            );
        }

        return new self(...$turns);
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
                TurnType::getByTurnByModifier($matches['turnType'] ?? ''),
                $move === strtolower($move) ? 2 : 1,
            );
        }

        return new self(...$turns);
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
            'turns' => $this->getTurns(),
        ];
    }
}
