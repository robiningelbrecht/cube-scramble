<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;

class Turn implements \JsonSerializable
{
    private const REGEX = "/^(?<slices>[2-9]+)?(?<move>[UuFfRrDdLlBbMESxyz])(?<outerBlockIndicator>w)?(?<turnType>\d+\\'|\\'\d+|\d+|\\')?$/";

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

    public static function fromNotationAndSize(string $notation, Size $size): self
    {
        if (!preg_match(self::REGEX, $notation, $matches)) {
            throw new InvalidScramble(sprintf('Invalid turn "%s", valid turns are %s', $notation, implode(', ', Move::casesAsStrings())));
        }

        $move = $matches['move'];
        $isLowerCaseMove = $move === strtolower($move) && !in_array($move, ['x', 'y', 'z']);
        if ($isLowerCaseMove) {
            $move = strtoupper($move);
        }

        $outerBlockIndicator = $matches['outerBlockIndicator'] ?? '';
        $slices = $matches['slices'] ?? null;
        if (!$outerBlockIndicator && $slices) {
            throw new InvalidScramble(sprintf('Invalid turn "%s", cannot specify number of slices if outer block move indicator "w" is not present', $notation));
        }

        if ($outerBlockIndicator && !$slices) {
            $slices = 2;
        }

        $slices = $slices ?? 1;

        $maxAllowedSlice = floor($size->getValue() / 2);
        if ($slices > $maxAllowedSlice) {
            throw new InvalidScramble(sprintf('Invalid turn "%s", slice cannot be greater than %s', $notation, $maxAllowedSlice));
        }

        return Turn::fromMoveAndTurnTypeAndSlices(
            $notation,
            Move::from($move),
            TurnType::getByTurnNotation($matches['turnType'] ?? ''),
            $isLowerCaseMove ? 2 : (int) $slices,
        );
    }

    public function getOpposite(): self
    {
        $notation = $this->getNotation();
        if (in_array($this->getTurnType(), [TurnType::CLOCKWISE, TurnType::COUNTER_CLOCKWISE])) {
            $notation = str_contains($this->getNotation(), "'") ? str_replace("'", '', $this->getNotation()) : $this->getNotation()."'";
        }

        return self::fromMoveAndTurnTypeAndSlices(
            $notation,
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
        ];
    }
}
