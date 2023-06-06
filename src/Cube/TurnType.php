<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Cube;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\TurnType as TurnTypeBase;

enum TurnType: string implements TurnTypeBase
{
    case CLOCKWISE = 'clockwise';
    case COUNTER_CLOCKWISE = 'counterClockwise';
    case DOUBLE = 'double';

    public function getOpposite(): self
    {
        return match ($this) {
            self::CLOCKWISE => self::COUNTER_CLOCKWISE,
            self::COUNTER_CLOCKWISE => self::CLOCKWISE,
            default => $this,
        };
    }

    public function getModifier(): string
    {
        return match ($this) {
            self::CLOCKWISE => '',
            self::COUNTER_CLOCKWISE => "'",
            self::DOUBLE => '2',
        };
    }

    public function forHumans(): ?string
    {
        return match ($this) {
            self::CLOCKWISE => 'clockwise',
            self::COUNTER_CLOCKWISE => 'counterclockwise',
            self::DOUBLE => null,
        };
    }

    public function getDegrees(): int
    {
        return match ($this) {
            self::CLOCKWISE, self::COUNTER_CLOCKWISE => 90,
            self::DOUBLE => 180,
        };
    }

    public static function random(): self
    {
        $turnTypes = TurnType::cases();

        return $turnTypes[array_rand($turnTypes)];
    }

    public static function getByTurnByModifier(string $modifier): self
    {
        return match ($modifier) {
            '' => self::CLOCKWISE,
            "'" => self::COUNTER_CLOCKWISE,
            '2', "2'", "'2" => self::DOUBLE,
            default => throw new InvalidScramble(sprintf('Invalid turnAbbreviation "%s"', $modifier)),
        };
    }
}
