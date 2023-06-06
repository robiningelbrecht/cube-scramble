<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;
use RobinIngelbrecht\CubeScramble\Turn as TurnBase;

class Turn implements TurnBase
{
    private const REGEX = "/^(?<slices>[2-9]+)?(?<move>[UFRDLB])(?<outerBlockIndicator>w)?(?<turnType>\d+\\'|\\'\d+|\d+|\\')?$/";

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
            throw new InvalidScramble(sprintf('Invalid turn "%s"', $notation));
        }

        $move = $matches['move'];
        $outerBlockIndicator = $matches['outerBlockIndicator'] ?? '';
        $slices = $matches['slices'] ?: null;
        if (!$outerBlockIndicator && $slices) {
            throw new InvalidScramble(sprintf('Invalid turn "%s", cannot specify number of slices if outer block move indicator "w" is not present', $notation));
        }

        if ($outerBlockIndicator && !$slices) {
            $slices = 2;
        }

        $slices = $slices ?? 1;

        if ($slices > $size->getMaxSlices()) {
            throw new InvalidScramble(sprintf('Invalid turn "%s", slice cannot be greater than %s', $notation, $size->getMaxSlices()));
        }

        return Turn::fromMoveAndTurnTypeAndSlices(
            $notation,
            Move::from($move),
            TurnType::getByTurnByModifier($matches['turnType'] ?? ''),
            $move === strtolower($move) ? 2 : (int) $slices,
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
