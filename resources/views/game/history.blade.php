@extends('layouts.app')
@section('title', 'История игр')
@section('content')
    <div class="max-w-5xl mx-auto mt-10">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">🎰 История игр</h2>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Число</th>
                    <th class="p-3 text-left">Статус</th>
                    <th class="p-3 text-left">Выигрыш</th>
                    <th class="p-3 text-left">Дата</th>
                </tr>
                </thead>
                <tbody>
                @foreach($games as $index => $game)
                    <tr class="border-b border-gray-300 hover:bg-gray-100 transition">
                        <td class="p-4 text-gray-800">{{ $index + 1 }}</td>
                        <td class="p-4 text-gray-800 font-semibold">{{ $game->number }}</td>
                        <td class="p-4">
                        <span class="px-3 py-1 text-white text-sm font-medium rounded-lg
                            @if($game->status === 'Win') bg-green-500
                            @elseif($game->status === 'Lose') bg-red-500
                            @else bg-gray-500 @endif">
                            {{ ucfirst($game->status) }}
                        </span>
                        </td>
                        <td class="p-4 font-semibold text-gray-800">
                            @if($game->prize > 0)
                                <span class=" text-green-600">
                                    💰 {{ number_format($game->prize, 2) }}
                                </span>
                            @else
                                <span class=" text-gray-600">
                                    ---
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-600">{{ $game->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-center">
            <a href="{{ route('game', ['token' => app('auth.token')]) }}" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-3
            text-lg font-bold rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all">
                🔥 Играть снова
            </a>
        </div>
    </div>
@endsection
