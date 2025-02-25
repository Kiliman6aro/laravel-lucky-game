<?php

namespace App\Services\Game;


use App\ValueObjects\GameResult;

class PrizeCalculator
{
    public function calculate(GameResult $result): float
    {
        if ($result->getStatus() !== 'Win') {
            return 0.0;
        }

        $number = $result->getNumber();

        if ($number > 900) {
            return round($number * 0.7, 2);
        } elseif ($number > 600) {
            return round($number * 0.5, 2);
        } elseif ($number > 300) {
            return round($number * 0.3, 2);
        } else {
            return round($number * 0.1, 2);
        }
    }
}
