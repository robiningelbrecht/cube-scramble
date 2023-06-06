<?php

namespace Tests\Cube;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\Size;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;

class SizeTest extends TestCase
{
    /**
     * @dataProvider provideSizes
     */
    public function testGetValue(int $size): void
    {
        $this->assertEquals(Size::fromInt($size)->getValue(), $size);
    }

    public function testItShouldThrowWhenTooLow(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid cube size 1 provided, valid range is 2 - 21.');

        Size::fromInt(1);
    }

    public function testItShouldThrowWhenTooHigh(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid cube size 22 provided, valid range is 2 - 21.');

        Size::fromInt(22);
    }

    public static function provideSizes(): array
    {
        return array_map(fn (int $size) => [$size], range(2, 21));
    }
}
