<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Cube;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans as ForHumansBase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class ForHumans implements ForHumansBase
{
    public function turn(Turn $turn): string
    {
        /** @var \RobinIngelbrecht\TwistyPuzzleScrambler\Cube\TurnType $turnType */
        $turnType = $turn->getTurnType();

        return trim(sprintf(
            'Turn the %s%s layer%s %s degrees %s',
            $turn->getMove()->forHumans(),
            $turn->getSlices() > 1 ? ' '.$turn->getSlices() : '',
            $turn->getSlices() > 1 ? 's' : '',
            $turnType->getDegrees(),
            $turn->getTurnType()->forHumans()
        ));
    }
}
