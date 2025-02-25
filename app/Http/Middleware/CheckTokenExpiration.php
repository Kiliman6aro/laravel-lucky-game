<?php

namespace App\Http\Middleware;

use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');

        $userToken = UserToken::where('token', $token)->first();

        if (!$userToken) {
            return redirect('/');
        }

        if (Carbon::now()->greaterThan($userToken->expired_at)) {
            return redirect('/');
        }

        $user = $userToken->user;
        if ($user) {
            Auth::login($user);
        } else {
            return redirect('/');
        }
        return $next($request);
    }
}
