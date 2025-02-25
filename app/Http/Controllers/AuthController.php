<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\User\RegisterService;
use Illuminate\View\View;

class AuthController extends Controller
{

    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function view(): View
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
    {
        $validate = $request->validated();
        $token = $this->registerService->register($validate['username'], $validate['phone_number']);
        return redirect(route('game', ['token' => $token]));
    }
}
