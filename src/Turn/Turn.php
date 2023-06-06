<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Turn;

use RobinIngelbrecht\TwistyPuzzleScrambler\Move;

class Turn implements \JsonSerializable
{
    private function __construct(
        private readonly string $notation,
        private readonly Move $move,
        private readonly TurnType $turnType,
        private readonly int $slices,
    ) {
    }

    public static function fromMoveAndTurnTypeAndSlices(
        string $notation,
        Move $move,
        TurnType $turnType,
        int $slices,
    ): self {
        return new self($notation, $move, $turnType, $slices);
    }

    public function getOpposite(): self
    {
        return self::fromMoveAndTurnTypeAndSlices(
            str_contains($this->getNotation(), "'") ? str_replace("'", '', $this->getNotation()) : $this->getNotation()."'",
            $this->getMove(),
            $this->getTurnType()->getOpposite(),
            $this->getSlices()
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
        return trim(sprintf(
            'Turn the %s%s layer%s %s degrees %s',
            $this->getSlices() > 1 ? $this->getSlices().' ' : '',
            $this->getMove()->forHumans(),
            $this->getSlices() > 1 ? 's' : '',
            $this->getTurnType()->getDegrees(),
            $this->getTurnType()->forHumans()
        ));
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
