<?php

namespace Tests\Skewb;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Skewb\SkewbScramble;
use Spatie\Snapshots\MatchesSnapshots;

class SkewbScrambleTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @dataProvider provideNotations()
     */
    public function testFromNotation(string $scramble): void
    {
        $scramble = SkewbScramble::fromNotation($scramble);
        $this->assertMatchesJsonSnapshot(json_encode(
            $scramble
        ));
        $this->assertMatchesTextSnapshot($scramble->forHumans());
    }

    /**
     * @dataProvider provideNotations()
     */
    public function testReverse(string $scramble): void
    {
        $scramble = SkewbScramble::fromNotation($scramble);
        $this->assertEquals($scramble->reverse()->reverse(), $scramble);
    }

    public function testItShouldThrowOnInvalidTurn(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turn "b"');

        SkewbScramble::fromNotation('b');
    }

    protected function getSnapshotId(): string
    {
        return (new \ReflectionClass($this))->getShortName().'--'.
            $this->name().'--'.
            $this->dataName().'--'.
            $this->snapshotIncrementor;
    }

    public static function provideNotations(): array
    {
        return [
            ["U' R L' U B' R L B' U'"],
            ["L' B' L' U B' U' R' U' B'"],
            ["L' U' L' B' R' L' B' L U'"],
        ];
    }
}
