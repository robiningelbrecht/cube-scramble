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
                'Rotate the top face 144° %s',
                $turn->getTurnType()->forHumans()
            );
        }

        return trim(sprintf(
            'Rotate the whole puzzle except the %s face, 144° %s',
            $turn->getMove()->forHumans(),
            $turn->getTurnType()->forHumans()
        ));
    }
}
