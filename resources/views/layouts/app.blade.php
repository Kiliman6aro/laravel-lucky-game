<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мое приложение')</title>
    @vite('resources/css/app.css')
    <!-- Подключение Alpine.js для интерактивности (если нужно) -->
</head>
<body class="bg-gray-50 font-sans antialiased">
<!-- Шапка -->
<header class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Логотип или название -->
        <a href="{{ route('game', ['token' => app('auth.token')]) }}" class="text-2xl font-bold tracking-tight hover:text-blue-200 transition-colors">
            Lucky Game
        </a>

        <!-- Навигация -->
        <nav class="flex items-center space-x-6">
            <!-- Ссылка "История" -->
            <a href="{{ route('game.history', ['token' => app('auth.token')]) }}" class="text-white hover:text-blue-200 font-medium transition-colors">
                История игр
            </a>

            <!-- Dropdown с Flowbite -->
            <div class="relative">
                <button id="dropdownButton" data-dropdown-toggle="dropdownMenu" class="flex items-center space-x-2 text-white hover:text-blue-200 focus:outline-none transition-colors cursor-pointer">
                    <span class="font-medium">Доступ</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-lg shadow-xl z-10 border border-gray-100">
                    <!-- Новая ссылка -->
                    <form action="{{ route('token.create', ['token' => app('auth.token')]) }}" method="POST" class="border-b border-gray-100">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer">
                            Новая ссылка
                        </button>
                    </form>
                    <!-- Деактивировать -->
                    <form id="deactivateForm" action="{{ route('token.deactivate', ['token' => app('auth.token')]) }}" method="POST">
                        @csrf
                        <button type="button" data-modal-target="deactivateModal" data-modal-toggle="deactivateModal" class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors cursor-pointer">
                            Выйти (Деактивировать)
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Основной контент -->
<main class="min-h-screen flex items-center justify-center bg-gray-50">
    @yield('content')
</main>
<div id="deactivateModal" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="relative bg-white rounded-lg shadow w-full max-w-md mx-4">
        <!-- Заголовок -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Подтверждение деактивации</h3>
            <button type="button" class="text-gray-400 hover:text-gray-900 rounded-lg p-1.5" data-modal-hide="deactivateModal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <!-- Тело -->
        <div class="p-6">
            <p class="text-gray-700">Если вы нажмёте "Деактивировать", вы автоматически выйдете из системы. Продолжить?</p>
        </div>
        <!-- Кнопки -->
        <div class="flex justify-end p-4 border-t border-gray-200 space-x-3">
            <button type="button" data-modal-hide="deactivateModal" class="bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded hover:bg-gray-300 transition-colors">
                Отмена
            </button>
            <button type="submit" form="deactivateForm" class="bg-red-600 text-white font-medium py-2 px-4 rounded hover:bg-red-700 transition-colors">
                Деактивировать
            </button>
        </div>
    </div>
</div>

<!-- Подключение скриптов -->
@vite('resources/js/app.js')
</body>
</html>
