<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;

class Size
{
    private function __construct(
        private readonly int $value
    ) {
        if ($this->value < 2 || $this->value > 21) {
            throw new InvalidScramble(sprintf('Invalid cube size %s provided, valid range is 2 - 21.', $this->value));
        }
    }

    public static function fromInt(int $size): self
    {
        return new self($size);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
