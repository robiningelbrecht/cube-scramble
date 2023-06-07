<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Pyraminx;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans as ForHumansBase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class ForHumans implements ForHumansBase
{
    public function turn(Turn $turn): string
    {
        // top layer including the tip
        if (2 == $turn->getSlices()) {
            return trim(sprintf(
                'Turn the %s layer, including the tip, %s',
                $turn->getMove()->forHumans(),
                $turn->getTurnType()->forHumans()
            ));
        }

        return trim(sprintf(
            'Turn the %s corner (tip) %s',
            $turn->getMove()->forHumans(),
            $turn->getTurnType()->forHumans()
        ));
    }
}
