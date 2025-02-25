<?php

namespace App\Auth;

use App\Services\User\TokenService;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;


class TokenGuard implements Guard
{
    use GuardHelpers;


    protected Request $request;

    protected TokenService $tokenService;

    public function __construct(UserProvider $provider, Request $request, TokenService $tokenService)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->tokenService = $tokenService;
    }

    public function user(): \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        if ($this->user) {
            return $this->user;
        }

        $token = $this->request->route('token');

        if (!$token) {
            return null;
        }

        $this->user = $this->tokenService->getUserByToken($token);

        app()->instance('auth.token', $token);

        return $this->user;
    }

    public function validate(array $credentials = []): bool
    {
        return false;
    }
}
