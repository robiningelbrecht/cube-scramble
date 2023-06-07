<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\CubeScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Cube\Size;
use RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx\PyraminxScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\RandomScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Skewb\SkewbScramble;
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

        $scramble = RandomScramble::pyraminx();
        $this->assertEquals(
            $scramble,
            PyraminxScramble::fromNotation($scramble),
        );
        $scrambleSize = count(explode(' ', (string) $scramble));
        $this->assertTrue($scrambleSize > 8 && $scrambleSize < 13);

        $scramble = RandomScramble::skewb();
        $this->assertEquals(
            $scramble,
            SkewbScramble::fromNotation($scramble),
        );
        $this->assertCount(9, explode(' ', (string) $scramble));
    }
}
