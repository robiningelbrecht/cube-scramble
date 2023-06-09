<?php

namespace Tests\Sq1;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\TwistyPuzzleScrambler\NotImplemented;
use RobinIngelbrecht\TwistyPuzzleScrambler\Sq1\NullTurnType;

class NullTurnTypeTest extends TestCase
{
    public function testGetOpposite(): void
    {
        $this->expectException(NotImplemented::class);

        NullTurnType::create()->getOpposite();
    }

    public function testGetModifier(): void
    {
        $this->expectException(NotImplemented::class);

        NullTurnType::create()->getModifier();
    }

    public function testForHumans(): void
    {
        $this->expectException(NotImplemented::class);

        NullTurnType::create()->forHumans();
    }

    public function testGetByTurnByModifier(): void
    {
        $this->expectException(NotImplemented::class);

        NullTurnType::getByTurnByModifier('f');
    }
}
