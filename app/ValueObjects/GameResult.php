<?php

namespace App\ValueObjects;

final class GameResult
{
    private int $number;
    private string $status;

    public function __construct(int $number)
    {
        $this->number = $number;
        $this->status = $this->determineStatus();
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isWin(): bool
    {
        return $this->status === 'Win';
    }

    public function isLose(): bool
    {
        return $this->status === 'Lose';
    }

    private function determineStatus(): string
    {
        return ($this->number % 2 === 0) ? 'Win' : 'Lose';
    }
}
