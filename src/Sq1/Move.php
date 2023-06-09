<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Sq1;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Move as MoveBase;

class Move implements MoveBase, \JsonSerializable
{
    private function __construct(
        private readonly int $topMove,
        private readonly int $bottomMove,
    ) {
        if ($this->topMove < -5 || $this->topMove > 6) {
            throw new InvalidScramble(sprintf('Invalid top move %s provided, valid range is -5 -> 6.', $this->topMove));
        }
        if ($this->bottomMove < -5 || $this->bottomMove > 5) {
            throw new InvalidScramble(sprintf('Invalid bottom move %s provided, valid range is -5 -> 5.', $this->bottomMove));
        }
    }

    public static function fromTopAndBottomMoves(int $topMove, int $bottomMove): self
    {
        return new self(
            $topMove,
            $bottomMove
        );
    }

    public static function random(): self
    {
        throw new \RuntimeException('Not supported');
    }

    public function getTopMove(): int
    {
        return $this->topMove;
    }

    public function getBottomMove(): int
    {
        return $this->bottomMove;
    }

    public function forHumans(): string
    {
        return 'todo';
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'topMove' => $this->getTopMove(),
            'bottomMove' => $this->getBottomMove(),
        ];
    }
}
