<?php

namespace Tests\Pyraminx;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx\PyraminxScramble;
use Spatie\Snapshots\MatchesSnapshots;

class PyraminxScrambleTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @dataProvider provideNotations()
     */
    public function testFromNotation(string $scramble): void
    {
        $scramble = PyraminxScramble::fromNotation($scramble);
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
        $scramble = PyraminxScramble::fromNotation($scramble);
        $this->assertEquals($scramble->reverse()->reverse(), $scramble);
    }

    public function testItShouldThrowOnInvalidTurn(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turn "V"');

        PyraminxScramble::fromNotation('V');
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
            ["L B L' R L' B U B l r b'"],
            ["L R' U L R' B R' L l' b'"],
            ["B' L R B' R' L' B U' l r'"],
            ["R B' R' B' R' B' U B' l' b'"],
            ["L' B' U L R' B' L' B' L' l b"],
        ];
    }
}
