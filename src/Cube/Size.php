<?php

namespace RobinIngelbrecht\CubeScramble\Cube;

use RobinIngelbrecht\CubeScramble\InvalidScramble;

class Size implements \JsonSerializable, \Stringable
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

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function jsonSerialize(): int
    {
        return $this->getValue();
    }
}
