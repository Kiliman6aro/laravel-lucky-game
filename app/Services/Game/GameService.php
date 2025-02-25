<?php

namespace App\Services\Game;


use App\ValueObjects\GameResult;

class GameService
{
    private RandomNumberGenerator $randomGenerator;

    public function __construct(?RandomNumberGenerator $randomGenerator = null)
    {
        $this->randomGenerator = $randomGenerator ?: new RandomNumberGenerator();
    }

    public function play(): GameResult
    {
        $number = $this->randomGenerator->generate(1, 1000);
        return new GameResult($number);
    }
}
