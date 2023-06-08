<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Sq1;

/*class Sq1 extends Scramble
{
    public static function random(int $scrambleSize): Scramble
    {
        $turns = [];
        for ($i = 0; $i < $numTurns; $i++) {
            $moves = $this->possibleMoves();
            $topMove = 0;
            $bottomMove = 0;

            do {
                $topMove = randomElement($moves['possibleTop']);
                $bottomMove = randomElement($moves['possibleBottom']);
            } while ($topMove === 0 && $bottomMove === 0);

            $turns[] = [
                'top' => $topMove,
                'bottom' => $bottomMove
            ];

            $this->turnTop($topMove);
            $this->turnBottom($bottomMove);
            $this->slice();
        }
    }

    public static function fromNotation(string $notation): Scramble
    {

    }

    private function turnTop($turns) {
        global $tops; // Assuming $tops is an array defined outside the function

        while ($turns != 0) {
            if ($turns < 0) {
                $piece = array_shift($tops);
                $turns += $piece;
                array_push($tops, $piece);
            } else if ($turns > 0) {
                $piece = array_pop($tops);
                $turns -= $piece;
                array_unshift($tops, $piece);
            }
        }
    }

    private function turnBottom($turns) {
        global $bottom; // Assuming $bottom is an array defined outside the function

        while ($turns != 0) {
            if ($turns < 0) {
                $piece = array_shift($bottom);
                $turns += $piece;
                array_push($bottom, $piece);
            } else if ($turns > 0) {
                $piece = array_pop($bottom);
                $turns -= $piece;
                array_unshift($bottom, $piece);
            }
        }
    }

    private function slice() {
        global $tops, $bottom; // Assuming $tops and $bottom are arrays defined outside the function

        $topNum = 0;
        $bottomNum = 0;

        $value = 0;

        for ($i = count($tops); $i > 0 && $value < 6; $i--) {
            $value += $tops[$i - 1];
            $topNum++;
        }

        $value = 0;
        for ($i = 0; $i < count($bottom) && $value < 6; $i++) {
            $value += $bottom[$i];
            $bottomNum++;
        }

        $topSlice = array_splice($tops, count($tops) - $topNum);
        $bottomSlice = array_splice($bottom, 0, $bottomNum);

        $tops = array_merge($tops, $bottomSlice);
        $bottom = array_merge($topSlice, $bottom);
    }

    private function isLayerAligned($layer) {
        $value = 0;
        for ($i = 0; $i < count($layer) && $value < 6; $i++) {
            $value += $layer[$i];
            if ($value > 6) {
                return false;
            }
        }

        return true;
    }

    private function isMovePossible($layer, $turns) {
        if ($turns < 0) {
            // Take off front, put on end
            while ($turns < 0) {
                $piece = array_shift($layer);
                if ($piece > abs($turns)) {
                    return false;
                }
                $turns += $piece;
                array_push($layer, $piece);
            }
            return $this->isLayerAligned($layer);
        } else if ($turns > 0) {
            // Take off end, put on front
            while ($turns > 0) {
                $piece = array_pop($layer);
                if ($turns < $piece) {
                    return false;
                }
                $turns -= $piece;
                array_unshift($layer, $piece);
            }
            return $this->isLayerAligned($layer);
        } else {
            // Turns = 0, should be possible
            return true;
        }
    }

    private function possibleMoves() {
        global $tops, $bottom; // Assuming $tops and $bottom are arrays defined outside the function

        $possibleTop = [];
        $possibleBottom = [];

        for ($i = -6; $i <= 6; $i++) {
            if ($this->isMovePossible([...$tops], $i)) {
                $possibleTop[] = $i;
            }
            if ($this->isMovePossible([...$bottom], $i)) {
                $possibleBottom[] = $i;
            }
        }

        return [
            "possibleTop" => $possibleTop,
            "possibleBottom" => $possibleBottom
        ];
    }

}*/
