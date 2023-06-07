<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Cube;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans as ForHumansBase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class ForHumans implements ForHumansBase
{
    public function turn(Turn $turn): string
    {
        return trim(sprintf(
            'Turn the %s%s layer%s %s degrees %s',
            $turn->getMove()->forHumans(),
            $turn->getSlices() > 1 ? ' '.$turn->getSlices() : '',
            $turn->getSlices() > 1 ? 's' : '',
            $turn->getTurnType()->getDegrees(),
            $turn->getTurnType()->forHumans()
        ));
    }
}
