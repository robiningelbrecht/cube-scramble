<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Sq1;

class Sq1
{
    /** @var int[] */
    private array $tops;
    /** @var int[] */
    private array $bottom;

    private function __construct()
    {
        $this->tops = [2, 1, 2, 1, 2, 1, 2, 1];
        $this->bottom = [1, 2, 1, 2, 1, 2, 1, 2];
    }

    public static function create(): self
    {
        return new self();
    }

    /**
     * @return array<int>
     */
    public function getPossibleTopMoves(): array
    {
        $possibleTopMoves = [];

        for ($i = -5; $i <= 6; ++$i) {
            if ($this->isMovePossible([...$this->tops], $i)) {
                $possibleTopMoves[] = $i;
            }
        }

        return $possibleTopMoves;
    }

    /**
     * @return array<int>
     */
    public function getPossibleBottomMoves(): array
    {
        $possibleBottomMoves = [];

        for ($i = -5; $i <= 5; ++$i) {
            if ($this->isMovePossible([...$this->bottom], $i)) {
                $possibleBottomMoves[] = $i;
            }
        }

        return $possibleBottomMoves;
    }

    public function turnTop(int $turns): void
    {
        while (0 != $turns) {
            if ($turns < 0) {
                /** @var int $piece */
                $piece = array_shift($this->tops);
                $turns += $piece;
                $this->tops[] = $piece;
            } elseif ($turns > 0) {
                $piece = array_pop($this->tops);
                $turns -= $piece;
                array_unshift($this->tops, $piece);
            }
        }
    }

    public function turnBottom(int $turns): void
    {
        while (0 != $turns) {
            if ($turns < 0) {
                /** @var int $piece */
                $piece = array_shift($this->bottom);
                $turns += $piece;
                $this->bottom[] = $piece;
            } elseif ($turns > 0) {
                $piece = array_pop($this->bottom);
                $turns -= $piece;
                array_unshift($this->bottom, $piece);
            }
        }
    }

    public function slice(): void
    {
        $topNum = 0;
        $bottomNum = 0;

        $value = 0;

        for ($i = count($this->tops); $i > 0 && $value < 6; --$i) {
            $value += $this->tops[$i - 1];
            ++$topNum;
        }

        $value = 0;
        for ($i = 0; $i < count($this->bottom) && $value < 6; ++$i) {
            $value += $this->bottom[$i];
            ++$bottomNum;
        }

        $topSlice = array_splice($this->tops, count($this->tops) - $topNum);
        $bottomSlice = array_splice($this->bottom, 0, $bottomNum);

        $this->tops = array_merge($this->tops, $bottomSlice);
        $this->bottom = array_merge($topSlice, $this->bottom);
    }

    /**
     * @param array<int> $layer
     */
    private function isLayerAligned(array $layer): bool
    {
        $value = 0;
        for ($i = 0; $i < count($layer) && $value < 6; ++$i) {
            $value += $layer[$i];
            if ($value > 6) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<int> $layer
     */
    private function isMovePossible(array $layer, int $turns): bool
    {
        if ($turns < 0) {
            while ($turns < 0) {
                /** @var int $piece */
                $piece = array_shift($layer);
                if ($piece > abs($turns)) {
                    return false;
                }
                $turns += $piece;
                $layer[] = $piece;
            }

            return $this->isLayerAligned($layer);
        } elseif ($turns > 0) {
            // Take off end, put on front
            while ($turns > 0) {
                /** @var int $piece */
                $piece = array_pop($layer);
                if ($turns < $piece) {
                    return false;
                }
                $turns -= $piece;
                array_unshift($layer, $piece);
            }

            return $this->isLayerAligned($layer);
        }

        return true;
    }
}
