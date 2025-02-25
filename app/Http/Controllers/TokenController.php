<?php

namespace App\Http\Controllers;

use App\Services\User\TokenService;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    private TokenService $tokenService;

    /**
     * @param TokenService $tokenService
     */
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }


    public function create()
    {
        $token = $this->tokenService->generateTokenForUser(Auth::user());
        return redirect(route('game', ['token' => $token]));
    }

    public function deactivate()
    {
        $this->tokenService->deactivateToken(app('auth.token'));
        return redirect(route('register.form'));
    }
}
