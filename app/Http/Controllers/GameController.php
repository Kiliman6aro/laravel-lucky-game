<?php

namespace App\Http\Controllers;

use App\Events\GamePlayed;
use App\Models\GameHistory;
use App\Services\Game\GameService;
use App\Services\Game\PrizeCalculator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GameController extends Controller
{

    private GameService $gameService;

    private PrizeCalculator $prizeCalculator;

    /**
     * @param GameService $gameService
     * @param PrizeCalculator $prizeCalculator
     */
    public function __construct(GameService $gameService, PrizeCalculator $prizeCalculator)
    {
        $this->gameService = $gameService;
        $this->prizeCalculator = $prizeCalculator;
    }


    public function index(): View
    {
        $user = Auth::user();
        return view('game.index');
    }

    public function history(): View
    {
        $games = GameHistory::where('user_id', auth()->id())
        ->latest()
        ->limit(3)
        ->get();

        return view('game.history', ['games' => $games]);
    }


    public function play()
    {
        $userId = Auth::user()->id;

        $gameResult = $this->gameService->play();
        if($gameResult->isWin()){
            $amountPrize = $this->prizeCalculator->calculate($gameResult);
        }else{
            $amountPrize = 0.00;
        }

        $data = [
            'status' => $gameResult->getStatus(),
            'number' => $gameResult->getNumber(),
            'prize' => $amountPrize,
        ];
        event(new GamePlayed($userId, $gameResult, $amountPrize));

        return response()->json($data);
    }
}
