<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\CubeScramble\Cube\CubeScramble;
use RobinIngelbrecht\CubeScramble\Cube\Size;
use RobinIngelbrecht\CubeScramble\RandomScramble;
use Spatie\Snapshots\MatchesSnapshots;

class RandomScrambleTest extends TestCase
{
    use MatchesSnapshots;

    public function testFactoryMethods(): void
    {
        $scramble = RandomScramble::twoByTwo();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(2)),
        );

        $scramble = RandomScramble::threeByThree();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(3)),
        );

        $scramble = RandomScramble::fourByFour();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(4)),
        );

        $scramble = RandomScramble::fiveByFive();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(5)),
        );

        $scramble = RandomScramble::sixBySix();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(6)),
        );

        $scramble = RandomScramble::sevenBySeven();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(7)),
        );
    }
}
