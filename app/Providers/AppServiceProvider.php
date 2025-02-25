<?php

namespace App\Providers;

use App\Auth\TokenGuard;
use App\Services\User\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::extend('token-url', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider']);
            $request = $app->make(Request::class);
            $tokenService = $app->make(TokenService::class);
            return new TokenGuard($provider, $request, $tokenService);
        });
    }
}
