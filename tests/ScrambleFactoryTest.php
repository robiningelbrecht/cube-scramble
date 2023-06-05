<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\CubeScramble\Cube\CubeScramble;
use RobinIngelbrecht\CubeScramble\Cube\Size;
use RobinIngelbrecht\CubeScramble\Scramble;
use RobinIngelbrecht\CubeScramble\ScrambleFactory;
use Spatie\Snapshots\MatchesSnapshots;

class ScrambleFactoryTest extends TestCase
{
    use MatchesSnapshots;

    private string $scrambleName;

    /**
     * @dataProvider provideScrambles()
     */
    public function testFactoryMethods(Scramble $scrambleFromFactory, Scramble $expectedScramble): void
    {
        $this->scrambleName = $scrambleFromFactory->getName();
        $this->assertEquals($scrambleFromFactory, $expectedScramble);
        $this->assertMatchesJsonSnapshot(json_encode($scrambleFromFactory));
    }

    protected function getSnapshotId(): string
    {
        return (new \ReflectionClass($this))->getShortName().'--'.
            $this->scrambleName.'--'.
            $this->snapshotIncrementor;
    }

    public static function provideScrambles(): array
    {
        return [
            [
                ScrambleFactory::twoByTwo("F2 U' R U2 R U R' F' R"),
                CubeScramble::fromNotation("F2 U' R U2 R U R' F' R", Size::fromInt(2)),
            ],
            [
                ScrambleFactory::threeByThree("R2 D B' D2 L' B' R' B2 U R2 B D2 L2 F' B' D2 R2 D2 F U2 R2"),
                CubeScramble::fromNotation("R2 D B' D2 L' B' R' B2 U R2 B D2 L2 F' B' D2 R2 D2 F U2 R2", Size::fromInt(3)),
            ],
            [
                ScrambleFactory::fourByFour("R' B D2 L B2 R' D2 L' D2 L2 F2 D2 R B2 D' U' F R' B' R2 U' Rw2 F L2 U' Fw2 U2 F Uw2 B' D2 L2 D' Uw2 L B' Rw Fw2 Uw2 Rw B Fw D2 Uw B Fw2 L'"),
                CubeScramble::fromNotation("R' B D2 L B2 R' D2 L' D2 L2 F2 D2 R B2 D' U' F R' B' R2 U' Rw2 F L2 U' Fw2 U2 F Uw2 B' D2 L2 D' Uw2 L B' Rw Fw2 Uw2 Rw B Fw D2 Uw B Fw2 L'", Size::fromInt(4)),
            ],
            [
                ScrambleFactory::fiveByFive("Lw' F2 D' L Bw2 D' Rw Fw Bw R2 Uw Lw2 Dw' F Fw2 Dw' Lw2 Rw2 Fw2 D R2 D' Bw2 Rw2 Bw' L R2 U Dw' R Bw' B Rw Bw2 F Dw2 L R2 F2 Dw2 U2 Bw' Dw F2 Lw' B R' L' U' F2 Bw R Fw2 F2 D2 B2 R L2 Bw' F"),
                CubeScramble::fromNotation("Lw' F2 D' L Bw2 D' Rw Fw Bw R2 Uw Lw2 Dw' F Fw2 Dw' Lw2 Rw2 Fw2 D R2 D' Bw2 Rw2 Bw' L R2 U Dw' R Bw' B Rw Bw2 F Dw2 L R2 F2 Dw2 U2 Bw' Dw F2 Lw' B R' L' U' F2 Bw R Fw2 F2 D2 B2 R L2 Bw' F", Size::fromInt(5)),
            ],
            [
                ScrambleFactory::sixBySix("Rw L2 3Uw' L' F' Uw2 D2 Lw' 3Uw2 U2 F' 3Uw' 3Fw Bw R 3Fw' B' U2 Bw2 D Bw2 3Fw' Fw' L Uw B 3Fw' Uw D 3Rw2 B' Rw2 Uw2 3Rw' Fw' U' B2 Fw2 Dw Uw' Lw2 F2 Rw2 Uw U D' R L2 Fw Uw' 3Fw2 B' Uw' Bw Rw2 3Fw Uw F2 3Fw2 R Dw2 Uw' L' F R' Rw 3Fw2 F2 Bw R' Bw Rw' U Rw' 3Fw2 3Rw2 Fw R2 3Fw 3Uw'"),
                CubeScramble::fromNotation("Rw L2 3Uw' L' F' Uw2 D2 Lw' 3Uw2 U2 F' 3Uw' 3Fw Bw R 3Fw' B' U2 Bw2 D Bw2 3Fw' Fw' L Uw B 3Fw' Uw D 3Rw2 B' Rw2 Uw2 3Rw' Fw' U' B2 Fw2 Dw Uw' Lw2 F2 Rw2 Uw U D' R L2 Fw Uw' 3Fw2 B' Uw' Bw Rw2 3Fw Uw F2 3Fw2 R Dw2 Uw' L' F R' Rw 3Fw2 F2 Bw R' Bw Rw' U Rw' 3Fw2 3Rw2 Fw R2 3Fw 3Uw'", Size::fromInt(6)),
            ],
            [
                ScrambleFactory::sevenBySeven("Lw' 3Rw2 3Fw Fw R Lw' 3Dw' Dw R 3Lw' D 3Dw' Dw2 L Uw2 3Lw 3Fw B' D2 Dw2 Lw B2 Fw2 U' B L' B2 Fw' Lw2 Bw F Rw' Lw U2 Dw' 3Bw B' Uw2 B' L' 3Rw2 U B' F2 R' Rw2 3Uw2 B R 3Dw' 3Uw2 3Lw2 3Fw' F2 Uw 3Uw L' Rw2 3Bw2 B 3Dw2 D' Bw2 3Bw' Uw2 3Bw' B' L 3Dw 3Lw' 3Fw R2 3Bw Fw' U' Uw' 3Uw2 F' Uw' 3Rw2 Rw Uw' Bw2 3Bw' R2 3Rw' 3Fw 3Bw2 3Uw' L Lw2 D2 Uw' U' Fw' F2 Lw2 L Uw Bw'"),
                CubeScramble::fromNotation("Lw' 3Rw2 3Fw Fw R Lw' 3Dw' Dw R 3Lw' D 3Dw' Dw2 L Uw2 3Lw 3Fw B' D2 Dw2 Lw B2 Fw2 U' B L' B2 Fw' Lw2 Bw F Rw' Lw U2 Dw' 3Bw B' Uw2 B' L' 3Rw2 U B' F2 R' Rw2 3Uw2 B R 3Dw' 3Uw2 3Lw2 3Fw' F2 Uw 3Uw L' Rw2 3Bw2 B 3Dw2 D' Bw2 3Bw' Uw2 3Bw' B' L 3Dw 3Lw' 3Fw R2 3Bw Fw' U' Uw' 3Uw2 F' Uw' 3Rw2 Rw Uw' Bw2 3Bw' R2 3Rw' 3Fw 3Bw2 3Uw' L Lw2 D2 Uw' U' Fw' F2 Lw2 L Uw Bw'", Size::fromInt(7)),
            ],
        ];
    }
}
