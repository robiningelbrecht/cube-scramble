<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Turn;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans;

class Turn implements \JsonSerializable
{
    private function __construct(
        private readonly string $notation,
        private readonly Move $move,
        private readonly TurnType $turnType,
        private readonly int $slices,
        private readonly ForHumans $forHumans
    ) {
    }

    public static function fromMoveAndTurnTypeAndSlices(
        string $notation,
        Move $move,
        TurnType $turnType,
        int $slices,
        ForHumans $forHumans,
    ): self {
        return new self($notation, $move, $turnType, $slices, $forHumans);
    }

    public function getOpposite(): self
    {
        return self::fromMoveAndTurnTypeAndSlices(
            str_contains($this->getNotation(), "'") ? str_replace("'", '', $this->getNotation()) : $this->getNotation()."'",
            $this->getMove(),
            $this->getTurnType()->getOpposite(),
            $this->getSlices(),
            $this->forHumans,
        );
    }

    public function getNotation(): string
    {
        return $this->notation;
    }

    public function getMove(): Move
    {
        return $this->move;
    }

    public function getTurnType(): TurnType
    {
        return $this->turnType;
    }

    public function getSlices(): int
    {
        return $this->slices;
    }

    public function forHumans(): string
    {
        return $this->forHumans->turn($this);
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'notation' => $this->getNotation(),
            'move' => $this->getMove(),
            'turnType' => $this->getTurnType(),
            'slices' => $this->getSlices(),
            'forHumans' => $this->forHumans(),
        ];
    }
}
