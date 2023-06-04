<?php

namespace Tests\Cube;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\CubeScramble\Cube\Move;

class MoveTest extends TestCase
{
    public function testCasesAsStrings(): void
    {
        $this->assertEquals('FURLDBMESxyz', implode('', Move::casesAsStrings()));
    }
}
