<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;


Route::get('/register', [AuthController::class, 'view'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:token')->group(function (){
    Route::get('/game/{token}', [GameController::class, 'index'])->name('game');
    Route::post('/game/{token}/play', [GameController::class, 'play'])->name('game.play');
    Route::get('/game/{token}/history', [GameController::class, 'history'])->name('game.history');

    Route::post('/token/{token}/create', [TokenController::class, 'create'])->name('token.create');
    Route::post('/token/{token}/deactivate', [TokenController::class, 'deactivate'])->name('token.deactivate');
});
