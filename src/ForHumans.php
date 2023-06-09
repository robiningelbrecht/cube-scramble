<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

interface ForHumans
{
    /**
     * @return string|string[]
     */
    public function turn(Turn $turn): string|array;
}
