<?php

namespace Tests\Cube;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\CubeScramble\Cube\Size;
use RobinIngelbrecht\CubeScramble\Cube\Turn;
use RobinIngelbrecht\CubeScramble\InvalidScramble;

class TurnTest extends TestCase
{
    public function testItShouldThrowWhenInvalidNotation(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turn "V"');

        Turn::fromNotationAndSize('V', Size::fromInt(3));
    }

    public function testItShouldThrowWhenInvalidOuterBlockIndicator(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turn "3U2", cannot specify number of slices if outer block move indicator "w" is not present');

        Turn::fromNotationAndSize('3U2', Size::fromInt(6));
    }

    public function testItShouldThrowWhenSlicesAreTooBig(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turn "Uw2", slice cannot be greater than 1');

        Turn::fromNotationAndSize('Uw2', Size::fromInt(3));
    }
}
