@extends('layouts.app')

@section('title', 'Панель управления | Обучающие игры')

@section('content')
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Обучающие JS-игры</h1>
            <p class="mt-2 text-gray-600">Интерактивные платформы для глубокого погружения в программирование.</p>
        </div>
        
        @if(auth()->user()->role === 'admin')
            <a href="#" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-bold shadow-sm transition">
                + Добавить ресурс
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition flex flex-col">
            <div class="p-6 flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full uppercase">Логика</span>
                    <span class="text-gray-400 text-sm">Open Source</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">JSRobot</h3>
                <p class="text-gray-600 text-sm mb-6">Управляйте роботом, изучая основы синтаксиса, циклы и функции JavaScript в игровой форме.</p>
                <a href="https://lab.reaal.me/jsrobot/" target="_blank" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Играть</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition flex flex-col">
            <div class="p-6 flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full uppercase">Алгоритмы</span>
                    <span class="text-gray-400 text-sm">Hard</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Elevator Saga</h3>
                <p class="text-gray-600 text-sm mb-6">Ваша задача — программировать движение лифтов на JS, чтобы максимально эффективно перевозить пассажиров.</p>
                <a href="http://play.elevatorsaga.com/" target="_blank" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Играть</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition flex flex-col">
            <div class="p-6 flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-full uppercase">MMO RTS</span>
                    <span class="text-gray-400 text-sm">Professional</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Screeps</h3>
                <p class="text-gray-600 text-sm mb-6">Полноценная стратегия, где вы пишете код для своей колонии юнитов, который работает 24/7.</p>
                <a href="https://screeps.com/" target="_blank" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Открыть сайт</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition flex flex-col">
            <div class="p-6 flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full uppercase">AI</span>
                    <span class="text-gray-400 text-sm">CLI Based</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">WarriorJS</h3>
                <p class="text-gray-600 text-sm mb-6">Проведите своего воина через башни, используя JavaScript для принятия решений в реальном времени.</p>
                <a href="https://warriorjs.com/" target="_blank" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Играть</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition flex flex-col">
            <div class="p-6 flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full uppercase">Hacking</span>
                    <span class="text-gray-400 text-sm">Medium</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Untrusted</h3>
                <p class="text-gray-600 text-sm mb-6">Мета-игра, в которой вы должны буквально изменять исходный код самой игры, чтобы пройти дальше.</p>
                <a href="https://alexnisnevich.github.io/untrusted/" target="_blank" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Играть</a>
            </div>
        </div>

    </div>
@endsection