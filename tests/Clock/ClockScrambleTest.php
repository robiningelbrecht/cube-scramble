<?php

namespace Tests\Clock;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Clock\ClockScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\InvalidScramble;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;
use Spatie\Snapshots\MatchesSnapshots;

class ClockScrambleTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @dataProvider provideNotations()
     */
    public function testFromNotation(string $scramble): void
    {
        $scramble = ClockScramble::fromNotation($scramble);
        $this->assertMatchesJsonSnapshot(json_encode(
            $scramble
        ));
        $this->assertMatchesTextSnapshot($scramble->forHumans());
        $this->assertCount(count(explode(' ', (string) $scramble)), $scramble->getTurns());
    }

    public function testReverse(): void
    {
        $this->expectException(NotImplemented::class);

        ClockScramble::fromNotation(
            'UR5- DR2+ DL4+ UL0+ U5- R4- D4- L2- ALL1- y2 U1+ R5- D2- L0+ ALL1+ DR DL UL'
        )->reverse();
    }

    public function testItShouldThrowOnInvalidTurn(): void
    {
        $this->expectException(InvalidScramble::class);
        $this->expectExceptionMessage('Invalid notation "UR5- DR2+ UL0+ U5- R4- D4- L2- ALL1- y2 U1+ R5- D2- L0+ ALL1+ DR DL UL"');

        ClockScramble::fromNotation('UR5- DR2+ UL0+ U5- R4- D4- L2- ALL1- y2 U1+ R5- D2- L0+ ALL1+ DR DL UL');
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
            ['UR5- DR2+ DL4+ UL0+ U5- R4- D4- L2- ALL1- y2 U1+ R5- D2- L0+ ALL1+ DR DL UL'],
            ['UR0+ DR1+ DL6+ UL0+ U2+ R1- D5+ L3- ALL0+ y2 U1+ R0+ D5- L2- ALL5+ UR DR'],
            ['UR6+ DR3- DL6+ UL5+ U3- R1- D5- L4+ ALL0+ y2 U5+ R4- D4- L3- ALL6+ UL'],
            ['UR1- DR2+ DL0+ UL3- U0+ R5- D4- L2- ALL4- y2 U2- R2- D5+ L5- ALL4+ DR DL'],
        ];
    }
}
