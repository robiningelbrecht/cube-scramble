<?php

namespace Tests\Megaminx;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx\Move;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;

class MoveTest extends TestCase
{
    public function testRandom(): void
    {
        $this->expectException(NotImplemented::class);

        Move::random();
    }
}
