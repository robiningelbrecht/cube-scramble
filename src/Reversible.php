<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler;

interface Reversible
{
    public function reverse(): Scramble;
}
