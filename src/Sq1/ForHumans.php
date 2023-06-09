<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Sq1;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans as ForHumansBase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class ForHumans implements ForHumansBase
{
    /**
     * @return string[]
     */
    public function turn(Turn $turn): array
    {
        /** @var \RobinIngelbrecht\TwistyPuzzleScrambler\Sq1\Move $move */
        $move = $turn->getMove();

        $forHumans = [];

        if ($move->getTopMove()) {
            $forHumans[] = sprintf(
                'Turn the top layer %s° %s',
                abs($move->getTopMove() * 30),
                $move->getTopMove() > 0 ? 'clockwise' : 'counterclockwise'
            );
        }
        if ($move->getBottomMove()) {
            $forHumans[] = sprintf(
                'Turn the bottom layer %s° %s',
                abs($move->getBottomMove() * 30),
                $move->getBottomMove() > 0 ? 'clockwise' : 'counterclockwise'
            );
        }

        return [
            ...$forHumans,
            'Turn the entire left half of the puzzle 180°',
        ];
    }
}
