<?php

namespace Tests\Sq1;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;
use RobinIngelbrecht\TwistyPuzzleScrambler\Sq1\Move;

class MoveTest extends TestCase
{
    public function testRandom(): void
    {
        $this->expectException(NotImplemented::class);

        Move::random();
    }

    public function testForHumans(): void
    {
        $this->expectException(NotImplemented::class);

        Move::fromTopAndBottomMoves(1, 2)->forHumans();
    }

    public function testItShouldThrowWhenTopMoveIsTooHigh(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid top move 8 provided, valid range is -5 -> 6');

        Move::fromTopAndBottomMoves(8, 3);
    }

    public function testItShouldThrowWhenTopMoveIsTooLow(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid top move -6 provided, valid range is -5 -> 6');

        Move::fromTopAndBottomMoves(-6, 3);
    }

    public function testItShouldThrowWhenBottomMoveIsTooHigh(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid bottom move 6 provided, valid range is -5 -> 5');

        Move::fromTopAndBottomMoves(5, 6);
    }

    public function testItShouldThrowWhenBottomMoveIsTooLow(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid bottom move -6 provided, valid range is -5 -> 5');

        Move::fromTopAndBottomMoves(5, -6);
    }
}
