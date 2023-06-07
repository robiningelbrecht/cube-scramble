<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\SimpleTurnType;

class SimpleTurnTypeTest extends TestCase
{
    /**
     * @dataProvider provideTurnTypes
     */
    public function testGetByTurnNotation(string $abbreviation, SimpleTurnType $expectedTurnType): void
    {
        $this->assertEquals(SimpleTurnType::getByTurnByModifier($abbreviation), $expectedTurnType);
    }

    public function testItShouldThrowWhenInvalid(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turnAbbreviation "y3"');

        SimpleTurnType::getByTurnByModifier('y3');
    }

    public static function provideTurnTypes(): array
    {
        return [
            ['', SimpleTurnType::CLOCKWISE],
            ['\'', SimpleTurnType::COUNTER_CLOCKWISE],
        ];
    }
}
