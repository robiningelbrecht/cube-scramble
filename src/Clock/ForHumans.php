<?php

namespace RobinIngelbrecht\TwistyPuzzleScrambler\Clock;

use RobinIngelbrecht\TwistyPuzzleScrambler\ForHumans as ForHumansBase;
use RobinIngelbrecht\TwistyPuzzleScrambler\Turn\Turn;

class ForHumans implements ForHumansBase
{
    public function turn(Turn $turn): string
    {
        if (Move::y === $turn->getMove()) {
            return 'Flip the clock over its side';
        }

        if ($turnType = $turn->getTurnType()->forHumans()) {
            if (in_array($turn->getMove(), Move::bothMoves())) {
                return sprintf(
                    'Raise both %s pins and move the corresponding dial(s) %s',
                    $turn->getMove()->forHumans(),
                    $turnType
                );
            }

            if (Move::ALL === $turn->getMove()) {
                return sprintf(
                    'Raise all pins and move the corresponding dial(s) %s',
                    $turnType
                );
            }

            return sprintf(
                'Raise the %s pin and move the corresponding dial(s) %s',
                $turn->getMove()->forHumans(),
                $turnType
            );
        }

        if (in_array($turn->getMove(), Move::bothMoves())) {
            return sprintf(
                'Raise both %s pins',
                $turn->getMove()->forHumans(),
            );
        }

        if (Move::ALL === $turn->getMove()) {
            return 'Raise all pins';
        }

        return sprintf(
            'Raise the %s pin',
            $turn->getMove()->forHumans(),
        );
    }
}
