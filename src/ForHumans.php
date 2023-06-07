<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

interface ForHumans
{
    public function turn(Turn $turn): string;
}
