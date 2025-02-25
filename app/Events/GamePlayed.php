<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GamePlayed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $userId,
        public object $gameResult,
        public float $prize
    ) {}
}
