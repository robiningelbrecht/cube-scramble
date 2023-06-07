<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Skewb;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans as ForHumansBase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class ForHumans implements ForHumansBase
{
    public function turn(Turn $turn): string
    {
        return trim(sprintf(
            'Turn the %s layer, including the tip, %s',
            $turn->getMove()->forHumans(),
            $turn->getTurnType()->forHumans()
        ));
    }
}
