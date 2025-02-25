<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    protected TokenService $tokenService;
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }


    /**
     * Регистрация нового пользователя.
     *
     * @param string $username
     * @param string $phone
     * @return string
     * @throws \Throwable
     */
    public function register(string $username, string $phone): string
    {
        return DB::transaction(function () use ($username, $phone) {
            $user = User::create([
                'username' => $username,
                'phone_number' => $phone,
            ]);

            return $this->tokenService->generateTokenForUser($user);
        });
    }
}
