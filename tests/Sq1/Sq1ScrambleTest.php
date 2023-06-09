<?php

namespace Tests\Sq1;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;
use RobinIngelbrecht\TwistyPuzzleScrambler\Sq1\Sq1Scramble;
use Spatie\Snapshots\MatchesSnapshots;

class Sq1ScrambleTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @dataProvider provideNotations()
     */
    public function testFromNotation(string $scramble): void
    {
        $scramble = Sq1Scramble::fromNotation($scramble);
        $this->assertMatchesJsonSnapshot(json_encode(
            $scramble
        ));
        $this->assertMatchesTextSnapshot($scramble->forHumans());
        $this->assertCount(count(explode(' ', (string) $scramble)), $scramble->getTurns());
    }

    public function testReverse(): void
    {
        $this->expectException(NotImplemented::class);

        Sq1Scramble::fromNotation(
            '(0,2)/ (1,-5)/ (-4,5)/ (3,0)/ (-2,-2)/ (3,0)/ (-4,0)/ (-3,-3)/ (0,-3)/ (-2,0)/ (-2,0)/ (2,0)/ (-4,0)/'
        )->reverse();
    }

    public function testItShouldThrowOnInvalidTurn(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid turn "(3,0)"');

        Sq1Scramble::fromNotation('(0,2)/ (1,-5)/ (-4,5)/ (3,0) (-2,-2)/ (3,0)/ (-4,0)/ (-3,-3)/ (0,-3)/ (-2,0)/ (-2,0)/ (2,0)/ (-4,0)/');
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
            ['(0,2)/ (1,-5)/ (-4,5)/ (3,0)/ (-2,-2)/ (3,0)/ (-4,0)/ (-3,-3)/ (0,-3)/ (-2,0)/ (-2,0)/ (2,0)/ (-4,0)/'],
            ['(0,-4)/ (-2,1)/ (0,-3)/ (5,-1)/ (0,-3)/ (-3,0)/ (3,-2)/ (-3,0)/ (-2,-3)/ (0,-4)/ (4,-2)/ (-1,0)/'],
            ['(-2,0)/ (3,0)/ (5,2)/ (-3,0)/ (3,0)/ (0,-3)/ (6,0)/ (-2,0)/ (-3,0)/ (0,-3)/ (1,0)/ (2,-2)/ (-4,0)/ (4,0)/'],
            ['(-3,-1)/ (4,-5)/ (3,0)/ (5,-1)/ (3,0)/ (-3,0)/ (0,-2)/ (0,-3)/ (-2,-3)/ (0,-4)/ (2,0)/ (3,0)/ (2,0)/'],
        ];
    }
}
