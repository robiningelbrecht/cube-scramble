<?php

namespace Tests\Clock;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Clock\TurnType;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;

class TurnTypeTest extends TestCase
{
    /**
     * @dataProvider provideTurnTypes
     */
    public function testGetByTurnNotation(string $abbreviation, TurnType $expectedTurnType): void
    {
        $this->assertEquals(TurnType::getByTurnByModifier($abbreviation), $expectedTurnType);
    }

    public function testItShouldThrowWhenInvalid(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turnAbbreviation "y3"');

        TurnType::getByTurnByModifier('y3');
    }

    public function testGetOpposite(): void
    {
        $this->expectException(NotImplemented::class);

        TurnType::FIVE_MINUS->getOpposite();
    }

    public static function provideTurnTypes(): array
    {
        return [
            ['0+', TurnType::ZERO_PLUS],
            ['1+', TurnType::ONE_PLUS],
            ['2+', TurnType::TWO_PLUS],
            ['3+', TurnType::THREE_PLUS],
            ['4+', TurnType::FOUR_PLUS],
            ['5+', TurnType::FIVE_PLUS],
            ['6+', TurnType::SIX_PLUS],
            ['0+', TurnType::ZERO_PLUS],
            ['1-', TurnType::ONE_MINUS],
            ['2-', TurnType::TWO_MINUS],
            ['3-', TurnType::THREE_MINUS],
            ['4-', TurnType::FOUR_MINUS],
            ['5-', TurnType::FIVE_MINUS],
            ['2', TurnType::DOUBLE],
            ['', TurnType::NONE],
        ];
    }
}
