<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Clock;

use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\TurnType as TurnTypeBase;

enum TurnType: string implements TurnTypeBase
{
    case ZERO_PLUS = '0+';
    case ONE_PLUS = '1+';
    case TWO_PLUS = '2+';
    case THREE_PLUS = '3+';
    case FOUR_PLUS = '4+';
    case FIVE_PLUS = '5+';
    case SIX_PLUS = '6+';
    case ONE_MINUS = '1-';
    case TWO_MINUS = '2-';
    case THREE_MINUS = '3-';
    case FOUR_MINUS = '4-';
    case FIVE_MINUS = '5-';
    case DOUBLE = '2';
    case NONE = '';

    public function getOpposite(): self
    {
        throw new \RuntimeException('Not supported');
    }

    public function getModifier(): string
    {
        return $this->value;
    }

    public function forHumans(): ?string
    {
        return match ($this) {
            self::ZERO_PLUS, self::NONE => '',
            self::ONE_PLUS => 'clockwise by 1 notch',
            self::TWO_PLUS => 'clockwise by 2 notches',
            self::THREE_PLUS => 'clockwise by 3 notches',
            self::FOUR_PLUS => 'clockwise by 4 notches',
            self::FIVE_PLUS => 'clockwise by 5 notches',
            self::SIX_PLUS => 'clockwise by 6 notches',
            self::ONE_MINUS => 'counterclockwise by 1 notch',
            self::TWO_MINUS => 'counterclockwise by 2 notches',
            self::THREE_MINUS => 'counterclockwise by 3 notches',
            self::FOUR_MINUS => 'counterclockwise by 4 notches',
            self::FIVE_MINUS => 'counterclockwise by 5 notches',
            default => throw new InvalidScramble(sprintf('Invalid turn type %s', $this->value))
        };
    }

    public static function random(): self
    {
        $turnTypes = array_filter(
            self::cases(),
            fn (TurnType $turnType) => !in_array($turnType, [TurnType::DOUBLE, TurnType::NONE])
        );

        return $turnTypes[array_rand($turnTypes)];
    }

    public static function getByTurnByModifier(string $modifier): self
    {
        foreach (self::cases() as $turnType) {
            if ($turnType->value !== $modifier) {
                continue;
            }

            return $turnType;
        }
        throw new InvalidScramble(sprintf('Invalid turnAbbreviation "%s"', $modifier));
    }
}
