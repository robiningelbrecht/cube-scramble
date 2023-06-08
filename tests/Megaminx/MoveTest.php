<?php

namespace Tests\Megaminx;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx\Move;

class MoveTest extends TestCase
{
    public function testRandom(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not supported');

        Move::random();
    }
}
