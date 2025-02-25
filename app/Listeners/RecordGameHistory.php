<?php

namespace App\Listeners;

use App\Events\GamePlayed;
use App\Models\GameHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RecordGameHistory implements ShouldQueue
{
    public int $tries = 3;
    public string $queue = 'game-history';

    public function handle(GamePlayed $event): void
    {
        GameHistory::create([
            'user_id' => $event->userId,
            'number' => $event->gameResult->getNumber(),
            'status' => $event->gameResult->getStatus(),
            'prize' => $event->prize,
        ]);
    }
}
