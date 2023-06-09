<?php

namespace Tests\Megaminx;

use PHPUnit\Framework\TestCase;
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
}
