@extends('layouts.app')

@section('title', "I'm Feeling Lucky")

@section('content')
    <div class="text-center">
        <div id="game-container" class="mt-8">
            <button id="play-button" class="bg-green-500 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:bg-green-600 transform hover:scale-105 transition duration-300 cursor-pointer">
                I'm Feeling Lucky
            </button>
            <div id="game-result" class="mt-6"></div> <!-- Контейнер для результата -->
        </div>
    </div>

    <script>
        document.getElementById('play-button').addEventListener('click', function () {
            // Временно отключаем кнопку только на время запроса
            this.disabled = true;

            fetch('{{ route('game.play', ['token' => app('auth.token')]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Ошибка сети');
                    }
                    return response.json();
                })
                .then(data => {
                    const resultContainer = document.getElementById('game-result');
                    resultContainer.innerHTML = ''; // Очищаем предыдущий результат

                    // Создаём "шар" с числом
                    const ball = document.createElement('div');
                    ball.className = 'w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg';
                    ball.textContent = data.number;

                    // Создаём сообщение о результате
                    const message = document.createElement('p');
                    message.className = data.status === 'Win' ? 'text-green-600 text-xl mt-4' : 'text-red-600 text-xl mt-4';
                    message.textContent = data.status === 'Win'
                        ? `Вы победили! Выигрыш: ${data.prize} ₴`
                        : `Вы проиграли. Выигрыш: ${data.prize} ₴`;

                    // Добавляем элементы в контейнер
                    resultContainer.appendChild(ball);
                    resultContainer.appendChild(message);

                    // Включаем кнопку обратно
                    document.getElementById('play-button').disabled = false;
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    const resultContainer = document.getElementById('game-result');
                    resultContainer.innerHTML = '<p class="text-red-600 text-xl mt-4">Произошла ошибка. Попробуйте позже.</p>';
                    document.getElementById('play-button').disabled = false;
                });
        });
    </script>
@endsection
