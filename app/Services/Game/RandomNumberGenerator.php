<?php

namespace App\Services\Game;

class RandomNumberGenerator
{
    public function generate(int $min, int $max): int
    {
        return rand($min, $max);
    }
}
