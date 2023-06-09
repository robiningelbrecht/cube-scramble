<?php

namespace Tests\Clock;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Clock\Move;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;

class MoveTest extends TestCase
{
    public function testRandom(): void
    {
        $this->expectException(NotImplemented::class);

        Move::random();
    }
}
