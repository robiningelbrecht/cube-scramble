<?php

namespace Tests\Clock;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Clock\Move;

class MoveTest extends TestCase
{
    public function testRandom(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not supported');

        Move::random();
    }
}
