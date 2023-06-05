<?php

namespace Tests\Cube;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\CubeScramble\Cube\TurnType;
use RobinIngelbrecht\CubeScramble\InvalidScramble;

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
            ['', TurnType::CLOCKWISE],
            ['\'', TurnType::COUNTER_CLOCKWISE],
            ['2', TurnType::DOUBLE],
            ['2\'', TurnType::DOUBLE],
            ['\'2', TurnType::DOUBLE],
        ];
    }
}
