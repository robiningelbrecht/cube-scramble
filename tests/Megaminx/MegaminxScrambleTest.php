<?php

namespace Tests\Megaminx;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx\MegaminxScramble;
use Spatie\Snapshots\MatchesSnapshots;

class MegaminxScrambleTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @dataProvider provideNotations()
     */
    public function testFromNotation(string $scramble): void
    {
        $scramble = MegaminxScramble::fromNotation($scramble);
        $this->assertMatchesJsonSnapshot(json_encode(
            $scramble
        ));
        $this->assertMatchesTextSnapshot($scramble->forHumans());
        $this->assertCount(count(explode(' ', (string) $scramble)), $scramble->getTurns());
    }

    public function testItShouldThrowOnInvalidTurn(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turn "b"');

        MegaminxScramble::fromNotation('b');
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
            ["R++ D++ R-- D++ R++ D-- R++ D-- R-- D-- U' R++ D-- R++ D++ R++ D++ R-- D-- R-- D-- U'"],
            ['R++ D-- R-- D-- R++ D++ R++ D-- R-- D++ U R-- D-- R++ D++ R-- D++ R++ D-- R-- D++ U R++ D-- R-- D-- R-- D++ R++ D-- R++ D++ U'],
        ];
    }
}
