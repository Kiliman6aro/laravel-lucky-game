@extends('layouts.base')

@section('title', 'Регистрация')
@section('content')
<div class="registration">
    @csrf
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Регистрация</h2>
            <form action="{{route('register')}}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Имя пользователя</label>
                    <input
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        type="text"
                        class="w-full p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('username') ? 'border border-red-400' : 'border border-gray-300' }}"
                    />
                    @error('username')
                    <span class="text-red-600 size-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                    <input
                        id="phone"
                        name="phone_number"
                        value="{{ old('phone_number') }}"
                        type="tel"
                        class="w-full p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('username') ? 'border border-red-400' : 'border border-gray-300' }}"
                    />
                    @error('phone')
                    <span class="text-red-600 size-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="w-full p-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                        Зарегистрироваться
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

