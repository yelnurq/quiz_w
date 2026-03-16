@extends('layouts.app')

@section('title', 'Панель управления | Викторины')

@section('content')
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Доступные викторины</h1>
            <p class="mt-2 text-gray-600">Выберите тему и проверьте свои знания.</p>
        </div>
        
        {{-- Кнопка только для админа --}}
        @if(auth()->user()->role === 'admin')
            <a href="#" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-bold shadow-sm transition">
                + Создать тест
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full uppercase">JavaScript</span>
                    <span class="text-gray-400 text-sm">15 вопросов</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Основы JS</h3>
                <p class="text-gray-600 text-sm mb-6">Проверка знаний по типам данных, замыканиям и синтаксису ES6+.</p>
                <a href="#" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Начать игру</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full uppercase">Laravel</span>
                    <span class="text-gray-400 text-sm">10 вопросов</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Laravel Архитектура</h3>
                <p class="text-gray-600 text-sm mb-6">Маршрутизация, Eloquent ORM и внедрение зависимостей.</p>
                <a href="#" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Начать игру</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 opacity-60">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-bold rounded-full uppercase">React</span>
                    <span class="text-gray-400 text-sm">Скоро</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">React Hooks</h3>
                <p class="text-gray-600 text-sm mb-6">Викторина по useEffect, useMemo и кастомным хукам.</p>
                <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-2 rounded-lg cursor-not-allowed">Заблокировано</button>
            </div>
        </div>
    </div>
@endsection