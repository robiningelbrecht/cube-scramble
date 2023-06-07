<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\TurnType as TurnTypeBase;

enum TurnType: string implements TurnTypeBase
{
    case MINUS_MINUS = '--';
    case PLUS_PLUS = '++';

    public function getOpposite(): self
    {
        return match ($this) {
            self::MINUS_MINUS => self::PLUS_PLUS,
            self::PLUS_PLUS => self::MINUS_MINUS,
        };
    }

    public function getModifier(): string
    {
        return match ($this) {
            self::MINUS_MINUS => '--',
            self::PLUS_PLUS => '++',
        };
    }

    public function forHumans(): ?string
    {
        return match ($this) {
            self::MINUS_MINUS => 'counterclockwise',
            self::PLUS_PLUS => 'clockwise',
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
            '--' => self::MINUS_MINUS,
            '++' => self::PLUS_PLUS,
            default => throw new InvalidScramble(sprintf('Invalid turnAbbreviation "%s"', $modifier)),
        };
    }
}
