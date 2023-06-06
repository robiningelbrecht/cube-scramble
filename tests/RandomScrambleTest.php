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
        $this->assertCount(9, explode(' ', (string) $scramble));

        $scramble = RandomScramble::threeByThree();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(3)),
        );
        $this->assertCount(20, explode(' ', (string) $scramble));

        $scramble = RandomScramble::fourByFour();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(4)),
        );
        $this->assertCount(44, explode(' ', (string) $scramble));

        $scramble = RandomScramble::fiveByFive();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(5)),
        );
        $this->assertCount(60, explode(' ', (string) $scramble));

        $scramble = RandomScramble::sixBySix();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(6)),
        );
        $this->assertCount(80, explode(' ', (string) $scramble));

        $scramble = RandomScramble::sevenBySeven();
        $this->assertEquals(
            $scramble,
            CubeScramble::fromNotation($scramble, Size::fromInt(7)),
        );
        $this->assertCount(100, explode(' ', (string) $scramble));
    }
}
