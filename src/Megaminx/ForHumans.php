<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Megaminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans as ForHumansBase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class ForHumans implements ForHumansBase
{
    public function turn(Turn $turn): string
    {
        if (Move::U === $turn->getMove()) {
            return sprintf(
                'Rotate the top face 144 degrees %s',
                $turn->getTurnType()->forHumans()
            );
        }

        /*
         * R++ and R-- for rotating the whole puzzle except the left face, 144° clockwise or counterclockwise respectively
         * D++ and D-- for rotating the whole puzzle except the top face, 144° clockwise or counterclockwise respectively
         */

        return trim(sprintf(
            'Rotate the whole puzzle except the %s face, 144 degrees %s',
            $turn->getMove()->forHumans(),
            $turn->getTurnType()->forHumans()
        ));
    }
}
