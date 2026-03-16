<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления | Викторины</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-600">DevQuiz</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Выйти</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Доступные викторины</h1>
            <p class="mt-2 text-gray-600">Выберите тему и проверьте свои знания.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full uppercase">JavaScript</span>
                        <span class="text-gray-400 text-sm">15 вопросов</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Основы JS</h3>
                    <p class="text-gray-600 text-sm mb-6">Проверка знаний по типам данных, замыканиям и современному синтаксису ES6+.</p>
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
                    <p class="text-gray-600 text-sm mb-6">Маршрутизация, Eloquent ORM и внедрение зависимостей (Service Container).</p>
                    <a href="#" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">Начать игру</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-teal-100 text-teal-800 text-xs font-bold rounded-full uppercase">Tailwind</span>
                        <span class="text-gray-400 text-sm">12 вопросов</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Утилитарные классы</h3>
                    <p class="text-gray-600 text-sm mb-6">Насколько хорошо вы знаете классы отступов, гридов и адаптивной верстки?</p>
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
                    <p class="text-gray-600 text-sm mb-6">Викторина по useEffect, useMemo и созданию кастомных хуков.</p>
                    <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-2 rounded-lg cursor-not-allowed">Заблокировано</button>
                </div>
            </div>

        </div>
    </main>

</body>
</html>