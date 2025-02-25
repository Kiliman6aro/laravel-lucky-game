<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Str;

class TokenService
{
    public function getUserByToken(?string $token): ?\App\Models\User
    {
        if (!$token) {
            return null;
        }

        $userToken = UserToken::where('token', $token)->first();

        if (!$userToken || $this->isTokenInvalid($userToken)) {
            return null;
        }

        return $userToken->user;
    }

    /**
     * Сгенерировать новый токен для пользователя
     */
    public function generateTokenForUser(User $user, int $expiresInDays = 7): string
    {
        do {
            $token = Str::random(60);
        } while (UserToken::where('token', $token)->exists());


        $expiresAt = now()->addDays($expiresInDays);

        UserToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expired_at' => $expiresAt,
            'is_active' => true,
        ]);

        return $token;
    }

    /**
     * Деактивировать токен
     */
    public function deactivateToken(string $token): bool
    {
        $userToken = UserToken::where('token', $token)->first();

        if (!$userToken) {
            return false;
        }

        $userToken->update(['is_active' => false]);

        return true;
    }

    protected function isTokenInvalid(UserToken $userToken): bool
    {
        return now()->greaterThan($userToken->expired_at) || !$userToken->is_active;
    }
}
