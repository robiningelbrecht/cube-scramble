<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;

class Turn implements \JsonSerializable
{
    private const REGEX = "/^(?<slices>[2-9]+)?(?<move>[UuFfRrDdLlBbMESxyz])(?<outerBlockIndicator>w)?(?<turnType>\d+\\'|\\'\d+|\d+|\\')?$/";

    private function __construct(
        private readonly string $notation,
        private readonly Face $face,
        private readonly TurnType $turnType,
        private readonly int $slices,
    ) {
    }

    public static function fromFaceAndTurnTypeAndSlices(
        string $notation,
        Face $face,
        TurnType $turnType,
        int $slices,
    ): self {
        return new self($notation, $face, $turnType, $slices);
    }

    public static function fromNotationAndSize(string $notation, Size $size): self
    {
        if (!preg_match(self::REGEX, $notation, $matches)) {
            throw new InvalidScramble(sprintf('Invalid turn "%s", valid turns are %s', $notation, implode(', ', Face::casesAsStrings())));
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

        if ($slices > $size->getMaxSlices()) {
            throw new InvalidScramble(sprintf('Invalid turn "%s", slice cannot be greater than %s', $notation, $size->getMaxSlices()));
        }

        return Turn::fromFaceAndTurnTypeAndSlices(
            $notation,
            Face::from($move),
            TurnType::getByTurnByModifier($matches['turnType'] ?? ''),
            $isLowerCaseMove ? 2 : (int) $slices,
        );
    }

    public function getOpposite(): self
    {
        $notation = $this->getNotation();
        if (in_array($this->getTurnType(), [TurnType::CLOCKWISE, TurnType::COUNTER_CLOCKWISE])) {
            $notation = str_contains($this->getNotation(), "'") ? str_replace("'", '', $this->getNotation()) : $this->getNotation()."'";
        }

        return self::fromFaceAndTurnTypeAndSlices(
            $notation,
            $this->getFace(),
            $this->getTurnType()->getOpposite(),
            $this->getSlices()
        );
    }

    public function getNotation(): string
    {
        return $this->notation;
    }

    public function getFace(): Face
    {
        return $this->face;
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
            'face' => $this->getFace(),
            'turnType' => $this->getTurnType(),
            'slices' => $this->getSlices(),
        ];
    }
}
