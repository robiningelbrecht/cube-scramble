<?php

namespace RobinIngelbrecht\CubeScramble;

interface Scramble
{
    public function fromNotation(string $notation): self;
}
