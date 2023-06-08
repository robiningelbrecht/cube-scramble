<?php

namespace Tests\Megaminx;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx\TurnType;

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

    public static function provideTurnTypes(): array
    {
        return [
            ['--', TurnType::MINUS_MINUS],
            ['++', TurnType::PLUS_PLUS],
        ];
    }
}
